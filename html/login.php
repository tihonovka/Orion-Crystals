<?php
session_start();
// DB adatai
$db_host = 'localhost';
$db_name = 'orionbase';
$db_user = 'orionbase';
$db_pass = 'exec br_core.cfg';
// kapcsolodik vele 
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
// alap verifikacio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        die("Please enter both username and password.");
    }
// kiveszi az adatbazisbol a nevet meg a jelszot, és oszehasnliti az user inputal
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
                //es ha sikeres akkor var 0,50 miliszekundomot és át dob a welcome.php ra 
                echo '<script>setTimeout(function(){window.location.href="welcome.php"},500);</script>';
                exit;
            } else {
                exit;
            }
        } else {
           
            exit;
        }
        // ez nemtom mi de nélkule nem mukodik
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    // lezarja a kapcsolatot
    unset($pdo);
}
?>
