<?php
require_once __DIR__ . '/include/auth.php';

$username = trim((string)($_POST['username'] ?? ''));
$pass = (string)($_POST['pass'] ?? '');

if ($username === '' || $pass === '') {
    echo '<br><br>';
    js_alert_redirect('You did not fill in a required field.', 'index.php');
    exit;
}

$stas = 'AC';
$stas_fl = 'N';

$check = $dbc->prepare('SELECT * FROM user_detail WHERE username=? AND status =? AND status_failed = ?');
$check->bind_param('sss', $username, $stas, $stas_fl);
$check->execute();
$result = $check->get_result();

while ($info = $result->fetch_assoc()) {
    if (!verify_password($pass, (string)$info['password'])) {
        handle_failed_login($dbc, $info, $username, $data_setup);
        continue;
    }

    // Cookie value is the stored hash, as ckies-brw.php/chk-auth_host.php compare against it.
    $stored = upgrade_password_hash($dbc, $username, $pass, (string)$info['password']);
    set_login_cookies($username, $stored);
    start_login_session($info, $username);
    if (login_runs_backjob($info)) {
        include 'backjob_clean.php';
    }
    redirect_to_level_home($info, $data_setup, $ua);
}
