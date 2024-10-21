<?php
// Include the database connection file
include 'dbconnection.php';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // echo "Connected successfully.<br>";

    // Generate a random OTP with letters, numbers, and symbols
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $otp = '';
    $length = 8; // Length of the OTP
    $maxIndex = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, $maxIndex)];
    }

    // Define the phone number
    $phoneNumber = '722902865'; // Define the phone number here

    // Store the OTP in the database
    $sql = "UPDATE cat SET otp = ? WHERE PhoneNumber = ?";
    $stmt = $pdo->prepare($sql);

    // Debugging: Check if statement was prepared
    if ($stmt === FALSE) {
        die("Prepare failed: " . $pdo->errorInfo()[2]);
    }

    $stmt->execute([$otp, $phoneNumber]);

    // Parameters for the SMS API
    $partnerID = '8854';
    $apikey = '70efa65617bcc559666d74e884c3abb6';
    $shortcode = 'Savvy_sms';
    $message = " " . $otp;

    // Construct the URL with parameters
    $url = 'https://sms.savvybulksms.com/api/services/sendsms';
    $url .= '?partnerID=' . urlencode($partnerID);
    $url .= '&mobile=' . urlencode('254' . $phoneNumber); // Assuming the phone number needs the country code
    $url .= '&apikey=' . urlencode($apikey);
    $url .= '&shortcode=' . urlencode($shortcode);
    $url .= '&message=' . urlencode($message);

    // Use cURL to send the SMS and get the response
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    // Debugging: Check if cURL request was successful
    if ($response === FALSE) {
        die("cURL Error: " . $curl_error);
    }

    // Check if SMS sending was successful and redirect to the appropriate page
    if ($httpcode == 200) {
        header("Location: otpform.html"); // Redirect to the OTP form on success
        exit;
    } else {
        header("Location: error.php"); // Redirect to error page on failure
        exit;
    }

    // Close the database connection
    $pdo = null;
} catch(PDOException $e) {
    // Handle PDO exceptions
    die("PDO Error: " . $e->getMessage());
}
?>
