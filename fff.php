<?php
// Include PHPMailer Autoload
require 'PHPMailer-master/src/PHPMailer.php';

// Create a new PHPMailer instance
$mail = new PHPMailer;

// Set the SMTP server details
$mail->isSMTP();
$mail->Host = 'host26.safaricombusiness.co.ke';  // Replace with your SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'richie@ndotoforest.org';
$mail->Password = 'Ilovemymum78!
';  // Replace with your email password
$mail->SMTPSecure = 'tls';  // Use 'tls' or 'ssl' based on your server configuration
$mail->Port = 465;  // Use the appropriate port for your server

// Set email details
$mail->setFrom('richie@ndotoforest.org', 'Your Name');
$mail->addAddress('richardwanjohirwm@gmail.com', 'Recipient Name');
$mail->Subject = 'Subject of the Email';
$mail->msgHTML('This is the HTML content of your email');

// Send the email
if ($mail->send()) {
    echo 'Email sent successfully.';
} else {
    echo 'Email sending failed. Error: ' . $mail->ErrorInfo;
}
?>
