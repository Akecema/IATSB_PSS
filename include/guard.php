<?php
// Loaded before every web request (auto_prepend_file, see docker/php.ini and .user.ini).
// Enforces the session login gate and folder-per-role access in one place, because the
// ~1,900 scripts under aac651b5c6ee/ and YWRtaW4=/ each carried a broken copy of it
// (`!isset(user) && lvl != X` only ever checked the login, never the level).

if (PHP_SAPI === 'cli') {
    return;
}

(function (): void {
    $root = str_replace(chr(92), '/', (string)realpath(__DIR__ . '/..'));
    $script = str_replace(chr(92), '/', (string)realpath($_SERVER['SCRIPT_FILENAME'] ?? ''));
    if ($script === '' || !str_starts_with($script, $root . '/')) {
        return;
    }
    $rel = substr($script, strlen($root) + 1);

    // Entry points that must work without a session. Board folders are wall displays;
    // scada_process.php is posted to by machines and has no user.
    $public_files = [
        'index.php', 'chk-auth.php', 'chk-auth_host.php', 'ckies-brw.php', 'mdl-login.php',
        'fgot-pswd.php', 'xfgt_psswd.php', 'login_lock.php', 'logout.php', 'blankPg.php',
        'status.php', 'scada_process.php', 'con-dbcIATSB.php', 'YWRtaW4=/verificationimage.php',
    ];
    $public_prefixes = ['cGhzvxff/', 'zGTfgbcode_QR/', 'PSS_IATSBboard/', 'PSS_IATSB_DLVboard/', 'include/'];

    $public = in_array($rel, $public_files, true);
    foreach ($public_prefixes as $prefix) {
        $public = $public || str_starts_with($rel, $prefix);
    }

    // Uploads: the legacy pages save $_FILES[..]['name'] as-is (path traversal, .php uploads) and trust
    // the client MIME type. Normalise the name and require an allowed extension whose content matches.
    if (!empty($_FILES)) {
        $reject = function (string $why): void {
            http_response_code(400);
            exit('Upload rejected: ' . $why);
        };
        $check = function (string $name, string $tmp, int $error) use ($reject): string {
            if ($error === UPLOAD_ERR_NO_FILE || $name === '') {
                return $name;
            }
            $base = basename(str_replace(chr(92), '/', $name));
            $base = preg_replace('/[^A-Za-z0-9._ ()-]/', '_', $base);
            $base = ltrim(str_replace('..', '_', $base), '.');
            $parts = explode('.', strtolower($base));
            $ext = count($parts) > 1 ? end($parts) : '';
            $allowed = ['xls', 'xlsx', 'csv', 'txt', 'pdf', 'png', 'jpg', 'jpeg', 'gif'];
            if (!in_array($ext, $allowed, true) || array_intersect(array_slice($parts, 0, -1), ['php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'php7', 'php8', 'htaccess'])) {
                $reject('file type not allowed.');
            }
            if ($tmp !== '' && is_uploaded_file($tmp)) {
                $head = (string)file_get_contents($tmp, false, null, 0, 8);
                $ok = match ($ext) {
                    'xls' => str_starts_with($head, "\xD0\xCF\x11\xE0"),
                    'xlsx' => str_starts_with($head, 'PK'),
                    'pdf' => str_starts_with($head, '%PDF'),
                    'csv', 'txt' => !str_contains((string)file_get_contents($tmp, false, null, 0, 4096), "\0"),
                    default => @getimagesize($tmp) !== false,
                };
                if (!$ok) {
                    $reject('file content does not match its extension.');
                }
            }
            return $base;
        };
        array_walk($_FILES, function (array &$f) use ($check): void {
            if (is_array($f['name'])) {
                foreach ($f['name'] as $k => $n) {
                    $f['name'][$k] = $check((string)$n, (string)$f['tmp_name'][$k], (int)$f['error'][$k]);
                }
            } else {
                $f['name'] = $check((string)$f['name'], (string)$f['tmp_name'], (int)$f['error']);
            }
        });
    }

    // Session cookie hardening for every request, public or not.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_set_cookie_params([
            'path' => '/', 'httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS']),
        ]);
        session_start();
    }
    // The login and forgot-password forms are public but still get CSRF protection.
    if ($public && !in_array($rel, ['index.php', 'xfgt_psswd.php'], true)) {
        return;
    }

    if (!$public && empty($_SESSION['username'])) {
        $depth = substr_count($rel, '/');
        header('Location: ' . str_repeat('../', $depth) . 'index.php');
        exit;
    }

    // CSRF: every state-changing request must echo the per-session token, either as the
    // csrf_token form field or the X-CSRF-Token header. Forms and XHR are patched below
    // so the ~1,900 legacy pages do not each need to be edited.
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['csrf_token'];
    if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'HEAD', 'OPTIONS'], true)) {
        $sent = (string)($_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
        if (!hash_equals($token, $sent)) {
            http_response_code(403);
            exit('Forbidden: invalid or missing CSRF token. Reload the page and try again.');
        }
    }
    // Scripts that change data on a plain GET (delete_*_item, SAP ftp pushes, ...). Links to them
    // get the token appended below, and a GET without it is refused.
    $get_mutating = [
        'close_sbarcode_single',
        'delete_bf_gr_item',
        'delete_bf_transit_item',
        'delete_bfhwork_gr_item',
        'delete_bfng_gr_item',
        'delete_bfpend_gr_item',
        'delete_dis_prdEng_item',
        'delete_dis_qc_item',
        'delete_dis_rec_item',
        'delete_do_othcust_itemSales',
        'delete_do_per2_item',
        'delete_do_per2_itemP2MSB',
        'delete_do_per2_itemSales',
        'delete_gis_item',
        'delete_gra_item',
        'delete_gra_return_item',
        'delete_kanban_item',
        'delete_rejcomp_item',
        'delete_tp-subcont_item',
        'delete_tp_item',
        'ftp_bflush_SAP',
        'ftp_bflush_SAP_NG',
        'ftp_bflush_SAP_cancel',
        'ftp_bflush_SAP_hwok-confirm',
        'ftp_bflush_SAP_hwork',
        'ftp_bflush_SAP_pend-confirm-rwk',
        'ftp_bflush_SAP_pend-confirm',
        'ftp_bflush_SAP_pend',
        'process_tran_pps',
    ];
    $script_name = basename($rel, '.php');
    if (in_array($script_name, $get_mutating, true) && $_SERVER['REQUEST_METHOD'] === 'GET'
        && !hash_equals($token, (string)($_GET['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''))) {
        http_response_code(403);
        exit('Forbidden: invalid or missing CSRF token. Go back, reload the page and try again.');
    }
    $get_re = '~\b(' . implode('|', array_map('preg_quote', $get_mutating)) . ')\.php\?~';
    ob_start(function (string $html) use ($token, $get_re): string {
        foreach (headers_list() as $h) {
            if (stripos($h, 'content-type:') === 0 && stripos($h, 'text/html') === false) {
                return $html;
            }
        }
        if (!preg_match('/<form\b|<head\b|\.php\?/i', $html)) {
            return $html;
        }
        $html = preg_replace($get_re, '$1.php?csrf_token=' . $token . '&', $html);
        $t = htmlspecialchars($token, ENT_QUOTES, 'UTF-8');
        $field = '<input type="hidden" name="csrf_token" value="' . $t . '">';
        // Same-origin POST forms only (relative or empty action).
        $html = preg_replace_callback('/<form\b[^>]*>/i', function (array $m) use ($field): string {
            $tag = $m[0];
            if (!preg_match('/\bmethod\s*=\s*["\']?post/i', $tag) || preg_match('/\baction\s*=\s*["\']?(https?:)?\/\//i', $tag)) {
                return $tag;
            }
            return $tag . $field;
        }, $html);
        $js = '<script>(function(){var T=' . json_encode($token) . ';'
            . 'var o=XMLHttpRequest.prototype.open,s=XMLHttpRequest.prototype.send;'
            . 'XMLHttpRequest.prototype.open=function(m,u){this._m=String(m).toUpperCase();return o.apply(this,arguments)};'
            . 'XMLHttpRequest.prototype.send=function(){if(this._m&&this._m!=="GET"&&this._m!=="HEAD"){try{this.setRequestHeader("X-CSRF-Token",T)}catch(e){}}return s.apply(this,arguments)};'
            . 'function add(f){if(!f.method||f.method.toLowerCase()!=="post"||f.querySelector("input[name=csrf_token]"))return;'
            . 'var i=document.createElement("input");i.type="hidden";i.name="csrf_token";i.value=T;f.appendChild(i)}'
            . 'document.addEventListener("submit",function(e){add(e.target)},true);'
            . 'var fs=HTMLFormElement.prototype.submit;HTMLFormElement.prototype.submit=function(){add(this);return fs.call(this)};'
            . 'if(window.fetch){var f0=fetch;window.fetch=function(u,c){c=c||{};var m=(c.method||"GET").toUpperCase();if(m!=="GET"&&m!=="HEAD"){c.headers=new Headers(c.headers||{});c.headers.set("X-CSRF-Token",T)}return f0(u,c)}}'
            . '})();</script>';
        $count = 0;
        $html = preg_replace('/<head\b[^>]*>/i', '$0' . $js, $html, 1, $count);
        if ($count === 0) {
            $html = preg_replace('/<form\b/i', $js . '<form', $html, 1);
        }
        return $html;
    });

    // Folder-per-role: user_detail.level_id 1 = admin, 2 = production (the only levels in use).
    $required_level = ['YWRtaW4=' => '1', 'aac651b5c6ee' => '2'][explode('/', $rel)[0]] ?? null;
    if ($required_level !== null && (string)($_SESSION['lvl_id'] ?? '') !== $required_level) {
        http_response_code(403);
        exit('Forbidden: insufficient role.');
    }
})();
