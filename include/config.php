<?php
// DB and PDIO API settings come from the environment - see .env.example.
$db_password = getenv('DB_PASSWORD');
if ($db_password === false || $db_password === '') {
    die('DB_PASSWORD environment variable is not set.');
}

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASSWORD', $db_password);
define('DB_NAME', getenv('DB_NAME') ?: 'pss_prjt_iatsb_db');

// Read by api_pdio_import.php, api_pdio_serendah.php, api_pdio_trigger.php.
define('PDIO_API_BASE_URL', getenv('PDIO_API_BASE_URL') ?: 'https://devdataspider.perodua.com.my');
define('PDIO_API_CLIENT_ID', getenv('PDIO_API_CLIENT_ID') ?: '');
define('PDIO_API_CLIENT_SECRET', getenv('PDIO_API_CLIENT_SECRET') ?: '');
define('PDIO_VENDOR_ID', getenv('PDIO_VENDOR_ID') ?: '211156');
define('PDIO_ORGANIZATION', getenv('PDIO_ORGANIZATION') ?: 'PMSB');

date_default_timezone_set('Asia/Kuala_Lumpur');

// Legacy pages check mysqli return values; PHP 8.1+ would throw instead.
mysqli_report(MYSQLI_REPORT_OFF);

// Azure Database for MySQL requires TLS and rejects a plain connection outright; the local
// Docker DB (host "db", or "localhost") does not speak TLS at all, so only negotiate SSL for a
// real remote host. DigiCertGlobalRootG2.crt.pem is Azure's CA - same cert used across this
// migration's sibling apps (i-proc, icharm, ...).
$dbc = mysqli_init();
if (!in_array(DB_HOST, ['localhost', 'db', '127.0.0.1'], true)) {
    mysqli_ssl_set($dbc, null, null, __DIR__ . '/DigiCertGlobalRootG2.crt.pem', null, null);
    $connected = mysqli_real_connect($dbc, DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, 3306, null, MYSQLI_CLIENT_SSL);
} else {
    $connected = mysqli_real_connect($dbc, DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
if (!$connected) {
    die('Connection Error.');
}

// This schema predates strict SQL mode (NOT NULL columns with no default, zero dates, implicit
// type coercion) - the local dev DB (MariaDB) tolerates that by default, but MySQL 8+ (Azure
// Database for MySQL) enforces strict mode unless told otherwise, breaking writes throughout the
// app (e.g. "Field 'vendor_no' doesn't have a default value"). Documented, scoped compromise for
// this pre-existing schema, not a default for new work - see PO_approve's po_pdf.sql for the same
// pattern in the reference app.
mysqli_query($dbc, "SET sql_mode = ''");

// Legacy pages build SQL by concatenation; these wrap every interpolated value.
// sql_esc(): value inside a quoted SQL literal. sql_num(): unquoted numeric value
// (anything that is not a plain number becomes 0, so it can never carry SQL).
if (!function_exists('sql_esc')) {
    function sql_esc($v): string
    {
        global $dbc;
        return mysqli_real_escape_string($dbc, (string)$v);
    }

    // Column names and sort direction cannot be bound or quoted, so they are constrained instead.
    function sql_ident($v): string
    {
        return preg_replace('/[^A-Za-z0-9_]/', '', (string)$v);
    }

    function sql_dir($v): string
    {
        return strtoupper((string)$v) === 'DESC' ? 'DESC' : 'ASC';
    }

    function sql_num($v): string
    {
        return preg_match('/^-?\d+(\.\d+)?$/', trim((string)$v)) ? trim((string)$v) : '0';
    }
}

// Output escaping for values echoed into HTML (DB rows, request and session data).
if (!function_exists('html_esc')) {
    function html_esc($v): string
    {
        return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// A query template with ? placeholders and its values. db_query() runs it as a real prepared
// statement; used as a plain string (concatenation, echo) it renders with escaped, quoted values.
if (!class_exists('PreparedSql')) {
    class PreparedSql implements Stringable
    {
        public function __construct(public string $sql, public array $params)
        {
        }

        public function __toString(): string
        {
            $i = 0;
            return preg_replace_callback('/\?/', function () use (&$i): string {
                return "'" . sql_esc($this->params[$i++] ?? '') . "'";
            }, $this->sql);
        }
    }

    // Drop-in for mysqli_query($dbc, $sql): SELECT gives a mysqli_result, writes give true,
    // failures give false. Falls back to the escaped string form if preparing fails.
    function db_query(mysqli $dbc, $sql)
    {
        if (!($sql instanceof PreparedSql)) {
            return mysqli_query($dbc, $sql);
        }
        // Keep the last write statement open: closing it resets mysqli_affected_rows($dbc), which
        // legacy pages read right after the query. Release the previous one before the next runs.
        static $lastWrite = null;
        $lastWrite = null;
        $stmt = $dbc->prepare($sql->sql);
        if (!$stmt) {
            return mysqli_query($dbc, (string)$sql);
        }
        if ($sql->params) {
            $vals = array_map('strval', array_values($sql->params));
            $stmt->bind_param(str_repeat('s', count($vals)), ...$vals);
        }
        if (!$stmt->execute()) {
            $stmt->close();
            return mysqli_query($dbc, (string)$sql);
        }
        $res = $stmt->get_result();
        if ($res === false) {
            $lastWrite = $stmt;
            return true;
        }
        $stmt->close();
        return $res;
    }
}
