<?php
include 'dbconnection.php'; // Include your database connection file

// Get form data
$id = $_POST['id'];
$marks = $_POST['marks'];

// Retrieve ADNO associated with the provided ID
$sqlAdno = "SELECT ADNO, img_name FROM recieved WHERE id = :id";
$stmtAdno = $db->prepare($sqlAdno);
$stmtAdno->bindParam(':id', $id);
$stmtAdno->execute();
$rowAdno = $stmtAdno->fetch(PDO::FETCH_ASSOC);

if ($rowAdno) {
    $adno = $rowAdno['ADNO'];
    $imgName = $rowAdno['img_name'];

    // Retrieve phone number associated with the ADNO from the 'login' table
    $sqlPhone = "SELECT phonenumber FROM logins WHERE ADNO = :adno";
    $stmtPhone = $db->prepare($sqlPhone);
    $stmtPhone->bindParam(':adno', $adno);
    $stmtPhone->execute();
    $rowPhone = $stmtPhone->fetch(PDO::FETCH_ASSOC);

    if ($rowPhone) {
        $phoneNumber = $rowPhone['phonenumber'];

        // Send SMS indicating the marks
        $partnerID = '8854';
        $apikey = '70efa65617bcc559666d74e884c3abb6';
        $shortcode = 'Savvy_sms';

        // Construct the message
        $message = "Marks for $imgName: $marks. Time UTC: " . date('Y-m-d H:i:s');

        // Construct the URL with parameters
        $url = 'https://sms.savvybulksms.com/api/services/sendsms';
        $url .= '?partnerID=' . urlencode($partnerID);
        $url .= '&mobile=' . urlencode($phoneNumber);
        $url .= '&apikey=' . urlencode($apikey);
        $url .= '&shortcode=' . urlencode($shortcode);
        $url .= '&message=' . urlencode($message);

        // Make a GET request to the Savvy Bulk SMS API
        file_get_contents($url); // This will send the SMS

        // Update the 'received' table with the marks and set marked to 1
        $sqlUpdate = "UPDATE recieved SET marks = :marks, marked = 1 WHERE id = :id";
        $stmtUpdate = $db->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':marks', $marks);
        $stmtUpdate->bindParam(':id', $id);
        $stmtUpdate->execute();

        $nairobiTime = date('Y-m-d H:i:s');
        $successMessage = urlencode("Marks submitted successfully. 'marked' column updated to 1. Marks for $imgName sent to $phoneNumber. Time UTC: $nairobiTime");
        header("Location: display_images.php?message=$successMessage");
        
    


// Include the database connection file
//include 'dbconnection.php';

try {
    // Get current SMS count for each user and update it by adding 0.7
    $sql_update_sms_count = "UPDATE logins SET sms_count = COALESCE(sms_count, 0) + 0.7 LIMIT 1";
    $stmt_update_sms_count = $db->prepare($sql_update_sms_count);
    $stmt_update_sms_count->execute();

  //  echo "SMS count updated for all users.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
        exit; // Ensure that no further code is executed after the redirect
    } else {
        echo "Error: Phone number not found for ADNO $adno.";
    }
} else {
    echo "Error: ADNO not found for the provided ID $id.";
}
?>

