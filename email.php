<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set recipient email address
    $to = "richardwanjohirwm@gmail.com";
    
    // Get the message from the form
    $message = $_POST["message"];
    
    // Set email subject
    $subject = "New message from website";
    
    // Set additional headers
    $headers = "From: richie@ndotoforest.org\r\n";
    $headers .= "Reply-To: richie@ndotoforest.org\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "Your message has been sent successfully.";
    } else {
        echo "Failed to send message. Please try again later.";
    }
    
    // Debugging
    echo "<br>Recipient: $to";
    echo "<br>Subject: $subject";
    echo "<br>Message: $message";
    echo "<br>Headers: <pre>$headers</pre>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
</head>
<body>
    <h2>Contact Us</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <textarea name="message" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Send">
    </form>
</body>
</html>
