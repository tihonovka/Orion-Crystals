<?php
session_start();

$db_host = 'localhost';
$db_name = 'orionbase';
$db_user = 'Orion';
$db_pass = 'fukarcici';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        die("Please enter both username and password.");
    }

    try {
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                session_regenerate_id();
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo '<div id="popup-message" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.18);padding:48px 64px;text-align:center;z-index:9999;font-family:Playwrite AU QLD,cursive;font-size:1.5em;color:#B68D40;">Login successful!<br>Redirecting...<br><button onclick="window.location.href=\'welcome.php\'" style="margin-top:24px;padding:12px 32px;border-radius:8px;background:#B68D40;color:#fff;font-size:1em;border:none;cursor:pointer;">Go to Welcome</button></div>';
                echo '<script>setTimeout(function(){window.location.href="welcome.php"},5000);</script>';
                exit;
            } else {
                echo '<div id="popup-message" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.18);padding:48px 64px;text-align:center;z-index:9999;font-family:Playwrite AU QLD,cursive;font-size:1.5em;color:#B68D40;">Invalid password.<br><button onclick="window.location.href=\'login.html\'" style="margin-top:24px;padding:12px 32px;border-radius:8px;background:#B68D40;color:#fff;font-size:1em;border:none;cursor:pointer;">Back to Login</button></div>';
                exit;
            }
        } else {
            echo '<div id="popup-message" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.18);padding:48px 64px;text-align:center;z-index:9999;font-family:Playwrite AU QLD,cursive;font-size:1.5em;color:#B68D40;">No account found with that username.<br><button onclick="window.location.href=\'login.html\'" style="margin-top:24px;padding:12px 32px;border-radius:8px;background:#B68D40;color:#fff;font-size:1em;border:none;cursor:pointer;">Back to Login</button></div>';
            exit;
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    unset($pdo);
}
?>
