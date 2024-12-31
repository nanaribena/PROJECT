<?php
$to = "n86587531@gmail.com";  // Replace with your own email address
$subject = "Test Email";
$message = "This is a test email from PHP.";
$headers = "From: no-reply@yourdomain.com\r\n";

if(mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
?>
