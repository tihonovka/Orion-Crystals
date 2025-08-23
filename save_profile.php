<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit;
}

$db_host = 'localhost';
$db_name = 'orionbase';
$db_user = 'Orion';
$db_pass = 'fukarcici';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

$username = $_SESSION['username'];
$payment_mode = $_POST['payment_mode'] ?? null;
$full_name = $_POST['full_name'] ?? null;
$address = $_POST['address'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$card_number = $_POST['card_number'] ?? null;
$card_name = $_POST['card_name'] ?? null;
$card_expiry = $_POST['card_expiry'] ?? null;
$card_cvc2 = $_POST['card_cvc2'] ?? null;

// Basic validation
if (!$payment_mode || !$full_name || !$address || !$phone || !$email) {
    echo "Please fill in all fields.";
    exit;
}
if ($payment_mode === 'Credit Card' && (!$card_number || !$card_name || !$card_expiry || !$card_cvc2)) {
    echo "Please fill in all credit card fields.";
    exit;
}

$sql = "UPDATE users SET payment_mode = :payment_mode, full_name = :full_name, address = :address, phone = :phone, email = :email WHERE username = :username";

if ($payment_mode === 'Credit Card') {
    $sql = "UPDATE users SET payment_mode = :payment_mode, full_name = :full_name, address = :address, phone = :phone, email = :email, card_number = :card_number, card_name = :card_name, card_expiry = :card_expiry, card_cvc2 = :card_cvc2 WHERE username = :username";
} else {
    $sql = "UPDATE users SET payment_mode = :payment_mode, full_name = :full_name, address = :address, phone = :phone, email = :email WHERE username = :username";
}
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':payment_mode', $payment_mode, PDO::PARAM_STR);
$stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
$stmt->bindParam(':address', $address, PDO::PARAM_STR);
$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
if ($payment_mode === 'Credit Card') {
    $stmt->bindParam(':card_number', $card_number, PDO::PARAM_STR);
    $stmt->bindParam(':card_name', $card_name, PDO::PARAM_STR);
    $stmt->bindParam(':card_expiry', $card_expiry, PDO::PARAM_STR);
    $stmt->bindParam(':card_cvc2', $card_cvc2, PDO::PARAM_STR);
}

if ($stmt->execute()) {
    header("Location: welcome.php?success=1");
    exit;
} else {
    echo "Error saving changes.";
}
?>