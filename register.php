<?php
// 1. Database Connection Details
$db_host = 'localhost';
$db_name = 'orionbase';
$db_user = 'Orion';
$db_pass = 'fukarcici';

// 2. Create a database connection
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// 3. Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 5. Basic Validation
    if (empty($username) || empty($password)) {
        die("Please enter both a username and password.");
    }

    // 6. Check if the username already exists
    try {
        $sql_check = "SELECT id FROM users WHERE username = :username";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            echo '<div id="popup-message" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.18);padding:48px 64px;text-align:center;z-index:9999;font-family:Playwrite AU QLD,cursive;font-size:1.5em;color:#B68D40;">That username is already taken.<br><button onclick="window.location.href=\'register.html\'" style="margin-top:24px;padding:12px 32px;border-radius:8px;background:#B68D40;color:#fff;font-size:1em;border:none;cursor:pointer;">Back to Register</button></div>';
            exit;
        }
    } catch (PDOException $e) {
        die("Error checking username: " . $e->getMessage());
    }

    // 7. Hash the password for secure storage
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 8. Insert the new user into the database
    try {
        $sql_insert = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt_insert = $pdo->prepare($sql_insert);

        $stmt_insert->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_insert->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt_insert->execute()) {
            echo '<div id="popup-message" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.18);padding:48px 64px;text-align:center;z-index:9999;font-family:Playwrite AU QLD,cursive;font-size:1.5em;color:#B68D40;">Registration successful!<br>You will be redirected to login in 5 seconds.<br><button onclick="window.location.href=\'login.html\'" style="margin-top:24px;padding:12px 32px;border-radius:8px;background:#B68D40;color:#fff;font-size:1em;border:none;cursor:pointer;">Go to Login Now</button></div>';
            echo '<script>setTimeout(function(){window.location.href="login.html"},5000);</script>';
        } else {
            echo '<div id="popup-message" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.18);padding:48px 64px;text-align:center;z-index:9999;font-family:Playwrite AU QLD,cursive;font-size:1.5em;color:#B68D40;">Something went wrong. Please try again.<br><button onclick="window.location.href=\'register.html\'" style="margin-top:24px;padding:12px 32px;border-radius:8px;background:#B68D40;color:#fff;font-size:1em;border:none;cursor:pointer;">Back to Register</button></div>';
        }
    } catch (PDOException $e) {
        die("Error inserting user: " . $e->getMessage());
    }

    // 9. Close the connection
    unset($pdo);
}
?>
