<?php
include 'dbconnection.php'; // Include your database connection file

try {
    // Validate and sanitize form data
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $marks = isset($_POST['marks']) ? htmlspecialchars($_POST['marks']) : null;

    // Validate inputs
    if ($id === null || $marks === null) {
        throw new Exception("Invalid input data.");
    }

    // Retrieve ADNO associated with the provided ID
    $sqlAdno = "SELECT adno, filename, idr FROM saved_images WHERE id = :id";
    $stmtAdno = $db->prepare($sqlAdno);
    $stmtAdno->bindParam(':id', $id);
    $stmtAdno->execute();
    $rowAdno = $stmtAdno->fetch(PDO::FETCH_ASSOC);

    if (!$rowAdno) {
        throw new Exception("No record found for the provided ID $id.");
    }

    $idr = $rowAdno['idr'];
    $adno = $rowAdno['adno'];
    $imgName = $rowAdno['filename'];

    // Retrieve phone number associated with the ADNO from the 'login' table
    $sqlPhone = "SELECT phonenumber FROM logins WHERE ADNO = :adno";
    $stmtPhone = $db->prepare($sqlPhone);
    $stmtPhone->bindParam(':adno', $adno);
    $stmtPhone->execute();
    $rowPhone = $stmtPhone->fetch(PDO::FETCH_ASSOC);

    if (!$rowPhone) {
        throw new Exception("Phone number not found for ADNO $adno.");
    }

    $phoneNumber = $rowPhone['phonenumber'];

    // Send SMS indicating the marks
    $partnerID = '8854';
    $apikey = '70efa65617bcc559666d74e884c3abb6';
    $shortcode = 'Savvy_sms';

    // Construct the message
    $message = "Remark for $imgName: $marks. Time UTC: " . gmdate('Y-m-d H:i:s');

    // Construct the URL with parameters
    $url = 'https://sms.savvybulksms.com/api/services/sendsms';
    $url .= '?partnerID=' . urlencode($partnerID);
    $url .= '&mobile=' . urlencode($phoneNumber);
    $url .= '&apikey=' . urlencode($apikey);
    $url .= '&shortcode=' . urlencode($shortcode);
    $url .= '&message=' . urlencode($message);

    // Make a GET request to the Savvy Bulk SMS API
    $smsResponse = file_get_contents($url); // This will send the SMS

    // Check if SMS sending was successful
    if (!$smsResponse) {
        throw new Exception("Failed to send SMS.");
    }

    // Start a transaction
    $db->beginTransaction();

    // Update the 'saved_images' table with the marks
    $sqlUpdate = "UPDATE recieved SET Marks = :marks,marked = 1 WHERE id = :idr";
    $stmtUpdate = $db->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':marks', $marks);
    $stmtUpdate->bindParam(':idr', $idr);
    $stmtUpdate->execute();



    // Update SMS count for the user
    $sqlUpdateSmsCount = "UPDATE logins SET sms_count = COALESCE(sms_count, 0) + 0.7 WHERE ADNO = :adno";
    $stmtUpdateSmsCount = $db->prepare($sqlUpdateSmsCount);
    $stmtUpdateSmsCount->bindParam(':adno', $adno);
    $stmtUpdateSmsCount->execute();

    // Commit the transaction
    $db->commit();

    // Redirect with success message
    $nairobiTime = date('Y-m-d H:i:s');
    $successMessage = urlencode("Marks submitted successfully. Marks for $imgName sent to $phoneNumber. Time UTC: $nairobiTime");
    header("Location: markedpics.php?message=$successMessage");
    exit; // Ensure that no further code is executed after the redirect

} catch (PDOException $e) {
    $db->rollBack(); // Rollback transaction in case of PDO exception
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
