
<?php
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['recipient'], $data['subject'], $data['body'])) {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

$to = $data['recipient'];
$subject = $data['subject'];
$body = $data['body'];
$headers = "From: noreply@orioncrystals.nhely.hu\r\nContent-Type: text/plain; charset=UTF-8";

if (mail($to, $subject, $body, $headers)) {
    http_response_code(200);
    echo "Email sent successfully.";
} else {
    http_response_code(500);
    echo "Failed to send email.";
}
?>