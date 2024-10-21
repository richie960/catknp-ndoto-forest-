<?php
// Include the database connection file
include 'dbconnection.php';

// Get the ID from the URL parameter
$id = $_GET['id'];

// Check if the information has already been posted
$sql_check_post = "SELECT post FROM cat WHERE id = :id";
$stmt_check_post = $db->prepare($sql_check_post);
$stmt_check_post->bindParam(':id', $id, PDO::PARAM_INT);
$stmt_check_post->execute();
$row_check_post = $stmt_check_post->fetch(PDO::FETCH_ASSOC);

// Check if 'post' column is already set to 1
if ($row_check_post['post'] == 1) {
    $nairobiTime = date('Y-m-d H:i:s');
    $errorMessage = urlencode("Information for ID $id has already been posted not accepted. Time UTC : $nairobiTime");
    header("Location: index.php?message=$errorMessage");
    exit;
}

// Fetch the PDF data based on the ID
$sql = "SELECT pdf, pdfname FROM cat WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

try {
    
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Save the PDF data to a file with the name from pdfname column and ".pdf" extension
        $filename = $row['pdfname'] . '.pdf';
        file_put_contents($filename, $row['pdf']);

        // Get students' phone numbers and SMS count from the logins table
        $sql_students = "SELECT id, phonenumber, sms_count FROM logins";
        $stmt_students = $db->prepare($sql_students);
        $stmt_students->execute();

        // Array to store messages
        $messages = array();

        while ($student_row = $stmt_students->fetch(PDO::FETCH_ASSOC)) {
            // Send SMS to each student
            $partnerID = '8854';
            $apikey = '70efa65617bcc559666d74e884c3abb6';
            $shortcode = 'Savvy_sms';
            $mobile = $student_row['phonenumber'];
            $message = "A new task has been added with the name of $filename.";

            // Construct the URL with parameters
            $url = 'https://sms.savvybulksms.com/api/services/sendsms';
            $url .= '?partnerID=' . urlencode($partnerID);
            $url .= '&mobile=' . urlencode($mobile);
            $url .= '&apikey=' . urlencode($apikey);
            $url .= '&shortcode=' . urlencode($shortcode);
            $url .= '&message=' . urlencode($message);

            // Make synchronous HTTP request using file_get_contents
            $response = file_get_contents($url);

            // Log or handle the response if needed
            // Note: This assumes the API returns a response that you may want to capture/log

            // Update SMS count
       
        }

        // Update 'post' column to 1 to prevent duplication
        $sql_update_post = "UPDATE cat SET post = 1 WHERE id = :id";
        $stmt_update_post = $db->prepare($sql_update_post);
        $stmt_update_post->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_update_post->execute();

        // Redirect to index.php after sending messages
        $nairobiTime = date('Y-m-d H:i:s');
        $successMessage = urlencode("Post was successful! PDF_NAME:$filename, Time UTC : $nairobiTime");
        header("Location: index.php?message=$successMessage");
        
//include 'dbconnection.php';

try {
    // Get current SMS count for each user and update it by adding 0.7
    $sql_update_sms_count = "UPDATE logins SET sms_count = COALESCE(sms_count, 0) + 0.7";
    $stmt_update_sms_count = $db->prepare($sql_update_sms_count);
    $stmt_update_sms_count->execute();

   // echo "SMS count updated for all users.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

        exit; // Ensure that no further code is executed after the redirects

    } else {
        $nairobiTime = date('Y-m-d H:i:s');
        $successMessage = urlencode("Post error ! not posted PDF_NAME:$filename, Time UTC : $nairobiTime");
        header("Location: index.php?message=$successMessage");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
