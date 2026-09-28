<?php
require_once __DIR__ . '/include/auth.php';

// A remember-me cookie logs the user straight in; the cookies are single-use
// and are cleared here whether or not the check passes.
if (isset($_COOKIE['ID_my_site'])) {
    session_unset();

    $username = (string)$_COOKIE['ID_my_site'];
    $pass = (string)($_COOKIE['Key_my_site'] ?? '');
    clear_login_cookies();

    $stas = 'AC';
    $stas_fl = 'N';

    $check = $dbc->prepare('SELECT * FROM user_detail WHERE username=? AND status =? AND status_failed = ?');
    $check->bind_param('sss', $username, $stas, $stas_fl);
    $check->execute();
    $result = $check->get_result();

    while ($info = $result->fetch_assoc()) {
        // The cookie carries the stored hash itself (set by chk-auth.php).
        if (!hash_equals((string)$info['password'], $pass)) {
            handle_failed_login($dbc, $info, $username, $data_setup);
            continue;
        }

        start_login_session($info, $username);
        if (login_runs_backjob($info)) {
            include 'backjob_clean.php';
        }
        redirect_to_level_home($info, $data_setup, $ua);
    }
}
