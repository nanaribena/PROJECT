<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Include PHPMailer

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com';  // Gmail username
    $mail->Password = 'your-email-password';   // Gmail password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;  // Port for TLS

    //Recipients
    $mail->setFrom('your-email@gmail.com', 'Mailer');
    $mail->addAddress('recipient@example.com', 'Joe User');  // Add recipient email

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = 'This is a <b>test email</b> sent using PHPMailer with Gmail SMTP!';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
