<?php
use SendGrid;
use SendGrid\Mail\Mail;

$email = new Mail();
$email->setFrom("your-email@example.com", "Mailer");
$email->setSubject("Test Email");
$email->addTo("recipient@example.com", "Joe User");
$email->addContent("text/plain", "This is a test email");

$sendgrid = new SendGrid('your-sendgrid-api-key');

try {
    $response = $sendgrid->send($email);
    echo $response->statusCode();
    echo $response->body();
    echo $response->headers();
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage();
}
?>
