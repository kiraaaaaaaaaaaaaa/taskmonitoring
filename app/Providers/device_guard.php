<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DMS_DEVICE_COOKIE', 'dms_device_token');
define('DMS_DEVICE_DAYS', 365);

function dmsClientIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    }

    return $_SERVER['REMOTE_ADDR'] ?? 'Unknown IP';
}

function dmsSecureRequest() {
    return (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
        (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
    );
}

function dmsSetDeviceCookie($value) {
    setcookie(DMS_DEVICE_COOKIE, $value, [
        'expires'  => time() + (DMS_DEVICE_DAYS * 24 * 60 * 60),
        'path'     => '/',
        'secure'   => dmsSecureRequest(),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

function dmsGetDeviceName($userAgent) {
    $ua = strtolower($userAgent);

    $os = 'Unknown OS';

    if (strpos($ua, 'windows') !== false) {
        $os = 'Windows';
    } elseif (strpos($ua, 'android') !== false) {
        $os = 'Android';
    } elseif (strpos($ua, 'iphone') !== false) {
        $os = 'iPhone';
    } elseif (strpos($ua, 'ipad') !== false) {
        $os = 'iPad';
    } elseif (strpos($ua, 'mac os') !== false || strpos($ua, 'macintosh') !== false) {
        $os = 'MacOS';
    } elseif (strpos($ua, 'linux') !== false) {
        $os = 'Linux';
    }

    $browser = 'Unknown Browser';

    if (strpos($ua, 'edg') !== false) {
        $browser = 'Microsoft Edge';
    } elseif (strpos($ua, 'opr') !== false || strpos($ua, 'opera') !== false) {
        $browser = 'Opera';
    } elseif (strpos($ua, 'chrome') !== false) {
        $browser = 'Google Chrome';
    } elseif (strpos($ua, 'firefox') !== false) {
        $browser = 'Mozilla Firefox';
    } elseif (strpos($ua, 'safari') !== false) {
        $browser = 'Safari';
    }

    return $os . ' - ' . $browser;
}

function dmsCreatePendingDevice($conn) {
    $selector  = bin2hex(random_bytes(16));
    $validator = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $validator);

    $deviceCode = 'DMS-' . strtoupper(substr(hash('sha256', $selector . microtime(true)), 0, 10));

    $ipAddress  = dmsClientIp();
    $userAgent  = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown User Agent';
    $deviceName = dmsGetDeviceName($userAgent);

    $stmt = $conn->prepare("
        INSERT INTO tbl_device_enrollments
            (selector, token_hash, device_code, device_name, status, ip_address, user_agent, created_at)
        VALUES
            (?, ?, ?, ?, 'pending', ?, ?, NOW())
    ");

    if (!$stmt) {
        die('Device enrollment error.');
    }

    $stmt->bind_param(
        "ssssss",
        $selector,
        $tokenHash,
        $deviceCode,
        $deviceName,
        $ipAddress,
        $userAgent
    );

    $stmt->execute();
    $stmt->close();

    dmsSetDeviceCookie($selector . ':' . $validator);

    return [
        'device_code' => $deviceCode,
        'device_name' => $deviceName,
        'status' => 'pending'
    ];
}

function dmsGetCurrentDevice($conn) {
    if (empty($_COOKIE[DMS_DEVICE_COOKIE])) {
        return dmsCreatePendingDevice($conn);
    }

    $cookieValue = $_COOKIE[DMS_DEVICE_COOKIE];
    $parts = explode(':', $cookieValue);

    if (count($parts) !== 2) {
        return dmsCreatePendingDevice($conn);
    }

    $selector  = $parts[0];
    $validator = $parts[1];

    if (
        !preg_match('/^[a-f0-9]{32}$/', $selector) ||
        !preg_match('/^[a-f0-9]{64}$/', $validator)
    ) {
        return dmsCreatePendingDevice($conn);
    }

    $stmt = $conn->prepare("
        SELECT 
            device_id,
            selector,
            token_hash,
            device_code,
            device_name,
            requested_name,
            requested_email,
            status
        FROM tbl_device_enrollments
        WHERE selector = ?
        LIMIT 1
    ");

    if (!$stmt) {
        die('Device verification error.');
    }

    $stmt->bind_param("s", $selector);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt->close();
        return dmsCreatePendingDevice($conn);
    }

    $device = $result->fetch_assoc();
    $stmt->close();

    $validatorHash = hash('sha256', $validator);

    if (!hash_equals($device['token_hash'], $validatorHash)) {
        return dmsCreatePendingDevice($conn);
    }

    $deviceId  = (int)$device['device_id'];
    $ipAddress = dmsClientIp();

    $update = $conn->prepare("
        UPDATE tbl_device_enrollments
        SET last_seen_at = NOW(),
            ip_address = ?
        WHERE device_id = ?
    ");

    if ($update) {
        $update->bind_param("si", $ipAddress, $deviceId);
        $update->execute();
        $update->close();
    }

    return $device;
}

function dmsShowUnauthorizedDevice($device) {
    $deviceCode = htmlspecialchars($device['device_code'] ?? 'Unknown');
    $deviceName = htmlspecialchars($device['device_name'] ?? 'Unknown Device');
    $status     = htmlspecialchars($device['status'] ?? 'pending');

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Unauthorized Device</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            * {
                box-sizing: border-box;
                font-family: Arial, sans-serif;
            }

            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #eef5f0;
                padding: 20px;
            }

            .device-card {
                width: 100%;
                max-width: 480px;
                background: #fff;
                border-radius: 18px;
                padding: 30px;
                box-shadow: 0 15px 40px rgba(0,0,0,.12);
                text-align: center;
                border-top: 8px solid #0f5132;
            }

            .icon {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                background: #fff3cd;
                color: #856404;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 34px;
                margin: 0 auto 15px;
            }

            h2 {
                margin: 0 0 10px;
                color: #0f5132;
            }

            p {
                color: #555;
                line-height: 1.5;
            }

            .code-box {
                background: #f4f6f5;
                border: 1px dashed #0f5132;
                padding: 14px;
                border-radius: 10px;
                margin: 18px 0;
                font-size: 20px;
                font-weight: bold;
                color: #0f5132;
                letter-spacing: 1px;
            }

            .info {
                text-align: left;
                background: #f8f9fa;
                padding: 14px;
                border-radius: 10px;
                margin-top: 15px;
                color: #444;
                font-size: 14px;
            }

            .status {
                display: inline-block;
                padding: 6px 12px;
                border-radius: 20px;
                background: #ffe8a1;
                color: #664d03;
                font-weight: bold;
                font-size: 13px;
                text-transform: uppercase;
            }

            .refresh-btn {
                display: inline-block;
                margin-top: 20px;
                padding: 11px 18px;
                border-radius: 10px;
                background: #0f5132;
                color: #fff;
                text-decoration: none;
                font-weight: bold;
            }
        </style>
    </head>
    <body>

        <div class="device-card">
            <div class="icon">🔒</div>

            <h2>This device is not authorized</h2>

            <p>
                Your device must be enrolled and approved by the system administrator before you can use the Document Management System.
            </p>

            <div class="code-box">
                <?= $deviceCode; ?>
            </div>

            <span class="status"><?= $status; ?></span>

            <div class="info">
                <strong>Detected device:</strong><br>
                <?= $deviceName; ?><br><br>

                <strong>Instruction:</strong><br>
                Send this Device Code to the system administrator for approval.
            </div>

            <a href="" class="refresh-btn">Check Again</a>
        </div>

    </body>
    </html>
    <?php
    exit;
}

function dmsRequireApprovedDevice($conn) {
    $device = dmsGetCurrentDevice($conn);

    if (($device['status'] ?? '') !== 'approved') {
        dmsShowUnauthorizedDevice($device);
    }

    return true;
}