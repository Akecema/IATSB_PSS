<?php
// Shared login helpers used by chk-auth.php (form login) and chk-auth_host.php /
// ckies-brw.php (cookie login). Extracted from the duplicated per-level branches.

const LOGIN_MAX_FAILURES = 5;

// Landing folder, page, and whether backjob_clean.php runs, per user_detail.level_id.
const LOGIN_HOME = [
    1 => ['YWRtaW4=', 'index_admin.php', false],
    2 => ['aac651b5c6ee', 'index_production.php', true],
    3 => ['ppc3JlY', 'index_ppc_rec.php', true],
    4 => ['cHBjqqc', 'index_qqc.php', false],
    5 => ['aHJvCOo', 'index_coO.php', false],
];

// user_detail.password is legacy unsalted md5; bcrypt is accepted too so accounts can
// be migrated to password_hash() without a code change here.
function verify_password(string $plain, string $stored): bool
{
    if (str_starts_with($stored, '$2y$')) {
        return password_verify($plain, $stored);
    }
    return hash_equals(strtolower($stored), md5($plain));
}

function count_recent_failed_logins(mysqli $dbc, string $username, string $ip): int
{
    $sql = "SELECT COUNT(*) FROM failed_login AS FL, user_detail AS UL
            WHERE FL.staff_ID = UL.staff_ID AND FL.username = ? AND FL.ip_address = ?
            AND FL.date_failed BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()";
    $stmt = $dbc->prepare($sql);
    $stmt->bind_param('ss', $username, $ip);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return (int)$count;
}

function record_failed_login(mysqli $dbc, string $ip, string $staff_id, string $username): bool
{
    $stmt = $dbc->prepare('INSERT INTO failed_login(ip_address,date_failed,staff_ID,username) VALUES(?,NOW(),?,?)');
    $stmt->bind_param('sss', $ip, $staff_id, $username);
    return $stmt->execute();
}

function js_alert_redirect(string $message, string $url): void
{
    echo '<script>alert(' . json_encode($message) . ');window.location=' . json_encode($url) . '</script>';
}

// Handles a wrong password: log the attempt, or lock the account and notify the
// administrator once LOGIN_MAX_FAILURES is reached in 24h.
function handle_failed_login(mysqli $dbc, array $info, string $username, array $data_setup): void
{
    $ip = $_SERVER['REMOTE_ADDR'];

    if (count_recent_failed_logins($dbc, $username, $ip) < LOGIN_MAX_FAILURES) {
        if (record_failed_login($dbc, $ip, (string)$info['staff_ID'], $username)) {
            js_alert_redirect('Incorrect password, please try again.', 'index.php');
        }
        return;
    }

    $lock = 'Y';
    $now = date('Y-m-d H:i:s');
    // Legacy quirk kept on purpose: "status_failed = ? AND date_failed = ?" is a boolean
    // expression, not two assignments; changing it alters what the lock writes.
    $stmt = $dbc->prepare('UPDATE user_detail SET status_failed = ? AND date_failed = ?, user_update = ?, date_update = ? WHERE username = ?');
    $stmt->bind_param('sssss', $lock, $now, $info['username'], $now, $username);

    if ($stmt->execute()) {
        $e = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
        $url = $e($data_setup['urls_system']);
        $body = '<p>Dear Sir; </br>'
            . '<p>Access to the web page was blocked. Details of the reset password changed as below; </p>'
            . '<html><body><table cellpadding="5">'
            . '<tr><td><strong>Username :</strong> </td><td>' . $e($username) . '</td></tr>'
            . '<tr><td><strong>Staff ID :</strong> </td><td>' . $e($info['staff_ID']) . '</td></tr>'
            . '</table><br>'
            . "<p>Please use the following link to view:</br><a href='{$url}'>{$url}</a> </p>"
            . "<p><font color='black'>This is a system generated email. Please DO NOT reply. </font></p>"
            . '<p>&nbsp;</p></body></html>';
        // Header values come from DB config; strip CR/LF to rule out header injection.
        $from = str_replace(["\r", "\n"], '', (string)$data_setup['email_account']);
        mail($info['user_email'], 'PSS Online Reset Account password changed.', $body,
            "From: {$from}\r\nContent-type: text/html; charset=iso-8859-1\r\n");
    }

    js_alert_redirect('You have tried more than 5 invalid attempts.', 'login_lock.php');
}

// Cookies mirror the legacy remember-me behaviour (ckies-brw.php consumes them).
function set_login_cookies(string $username, string $key): void
{
    $opts = ['expires' => time() + 3600, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax',
             'secure' => !empty($_SERVER['HTTPS'])];
    setcookie('ID_my_site', $username, $opts);
    setcookie('Key_my_site', $key, $opts);
}

function clear_login_cookies(): void
{
    $opts = ['expires' => time() - 100, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax'];
    foreach (['ID_my_site', 'Key_my_site', 'Lvl_my_site'] as $name) {
        setcookie($name, '', $opts);
    }
}

// Starts the authenticated session; no credential is stored in it.
function start_login_session(array $info, string $username): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_regenerate_id(true);
    $_SESSION['username'] = $username;
    $_SESSION['lvl_id'] = $info['level_id'];
}

// Callers include backjob_clean.php themselves: it reads $username and $dbc from the
// global scope, so it cannot be included from inside a function.
function login_runs_backjob(array $info): bool
{
    return LOGIN_HOME[(int)$info['level_id']][2] ?? false;
}

// Redirects to the level's home page, only for the browsers the legacy code supported.
function redirect_to_level_home(array $info, array $data_setup, array $ua): void
{
    $level = (int)$info['level_id'];
    if (isset(LOGIN_HOME[$level])) {
        [$dir, $page] = LOGIN_HOME[$level];
        $location = $data_setup['urls_system'] . "/{$dir}/{$page}?lvl={$level}&&page=" . encode($page, 5);
    } else {
        $location = $data_setup['urls_system'] . '/blankPg.php';
    }

    if (in_array($ua['name'], ['Google Chrome', 'Apple Safari', 'Mozilla Firefox'], true)) {
        header('Location: ' . $location);
    }
}
