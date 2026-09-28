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

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$dbc) {
    die('Connection Error.');
}

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
