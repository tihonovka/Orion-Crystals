<?php
//AdatBázis adatai a csatlakozashoz 
$db_host = 'localhost';
$db_name = 'orionbase';
$db_user = 'orionbase';
$db_pass = 'exec br_core.cfg';

// eza  szar letrehozza a kapcsolatot
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// le ellenörzi létesitett e kapcsolatot
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ez megkapja a jelszot es a nevet es lelopja
    $username = $_POST['username'];
    $password = $_POST['password'];

    // verifikacio
    if (empty($username) || empty($password)) {
        die("Please enter both a username and password.");
    }

    //vegig fut aza datbazison és megnezi létezik e a juzer :3
    try {
        $sql_check = "SELECT id FROM users WHERE username = :username";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            echo '<div id="popup-message" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,0.18);padding:48px 64px;text-align:center;z-index:9999;font-family:Playwrite AU QLD,cursive;font-size:1.5em;;">That username is already taken.<br><button onclick="window.location.href=\'register.html\'" style="margin-top:24px;padding:12px 32px;border-radius:8px;background: linear-gradient(90deg, #A6EBC9, #61FF7E, #5EEB5B, #62AB37, #F7F6C5);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;color:#fff;font-size:1em;border:none;cursor:pointer;">Back to Register</button></div>';
            exit;
        }
    } catch (PDOException $e) {
        die("Error checking username: " . $e->getMessage());
    }

    // le hesseli a jelszot ilyen enkripcio ahh typeshi
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // ez belerakja a fukar-t a tablazatba
    try {
        $sql_insert = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt_insert = $pdo->prepare($sql_insert);

        $stmt_insert->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_insert->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt_insert->execute()) {
            echo '<script>setTimeout(function(){window.location.href="login.html"},500);</script>';
        } else {
        }
    } catch (PDOException $e) {
        die("Error inserting user: " . $e->getMessage());
    }

    // lezarja a kapcsolatot
    unset($pdo);
}
?>
