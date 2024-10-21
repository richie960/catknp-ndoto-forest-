<?php
// Include the database connection file
include 'dbconnection.php';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the OTP is set in the POST request
    if (isset($_POST['otp'])) {
        // Sanitize and validate the OTP input
        $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING);

        // Fetch the OTP from the database for comparison
        $sql = "SELECT otp FROM cat LIMIT 1";
        $stmt = $pdo->query($sql);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $storedOtp = $row['otp'];

            // Compare the input OTP with the stored OTP
            if ($otp === $storedOtp) {
                // OTP is correct, redirect to the success page
                header("Location: admin_teach.php");
                exit;
            } else {
                // OTP is incorrect, redirect to the error page
                header("Location: otpform.html");
                exit;
            }
        } else {
            echo "No OTP found in the database.";
        }
    } else {
        echo "No OTP provided.";
    }
} catch(PDOException $e) {
    // Handle PDO exceptions
    die("PDO Error: " . $e->getMessage());
} finally {
    // Close the database connection
    $pdo = null;
}
?>
