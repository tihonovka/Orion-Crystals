<?php
// Teszt merchant adatok (sandboxból származnak, helyettesítsd a sajátoddal!)
$merchant = "PUBLICTESTHUF";
$secretKey = "123456789"; // IDE a saját sandbox/éles secret kulcs
$endpoint = "https://sandbox.simplepay.hu/payment/v2/start";

$email  = $_POST['email'];
$amount = $_POST['amount'];

$orderRef = "ORD-" . time();  // egyedi rendelésazonosító
$salt     = bin2hex(random_bytes(16)); // véletlen só

// Visszatérési URL (ahova a vásárló fizetés után jön)
$returnUrl = "https://sajatdomain.hu/thankyou.php";

// Fizetési kérés összeállítása
$payload = [
  "salt" => $salt,
  "merchant" => $merchant,
  "orderRef" => $orderRef,
  "currency" => "HUF",
  "customerEmail" => $email,
  "language" => "HU",
  "methods" => ["CARD"],
  "total" => strval($amount),
  "timeout" => date("c", time() + 600), // 10 perc
  "url" => $returnUrl
];

$raw = json_encode($payload, JSON_UNESCAPED_SLASHES);

// Aláírás készítése (HMAC-SHA384 + Base64)
$signature = base64_encode(hash_hmac("sha384", $raw, $secretKey, true));

// HTTP POST kérés cURL-lel
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json",
  "Signature: " . $signature
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $raw);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// Ha sikerült, irányítsuk a felhasználót a SimplePay oldalra
if (isset($data['paymentUrl'])) {
  header("Location: " . $data['paymentUrl']);
  exit;
} else {
  echo "<pre>Hiba történt:\n";
  print_r($data);
  echo "</pre>";
}
