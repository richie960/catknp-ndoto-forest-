<?php
date_default_timezone_set('Africa/Nairobi'); 
include 'dbconnection.php'; // Include your database connection file

// Function to generate a unique filename based on Image name
function generateUniqueFilename($filename, $uploadPath, $imgName) {
    $fullPath = $uploadPath . $imgName . '_' . $filename;
    $counter = 1;

    while (file_exists($fullPath)) {
        $filename = $imgName . '_' . $filename;
        $fullPath = $uploadPath . $filename;
        $counter++;
    }

    return $filename;
}

// Get admission number and Image name from the form
$admissionNumber = $_POST['admission_number'];
$imgName = $_POST['img_name'];

// Directory to store uploaded images
$uploadPath = 'uploads/';

// Check if the directory exists, create it if not
if (!file_exists($uploadPath)) {
    mkdir($uploadPath, 0777, true);
}

// Initialize an array to store uploaded filenames
$uploadedFiles = array();

// Check if a single file or multiple files are uploaded
if (!empty($_FILES['images']['tmp_name'][0])) {
    // Loop through each uploaded file
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['images']['name'][$key];
        $file_tmp = $_FILES['images']['tmp_name'][$key];

        // Generate a unique filename to avoid overwriting
        $uniqueFilename = generateUniqueFilename($file_name, $uploadPath, $imgName);

        // Move the uploaded file to the destination directory
        move_uploaded_file($file_tmp, $uploadPath . $uniqueFilename);

        // Add the filename to the array
        $uploadedFiles[] = $uniqueFilename;
    }
}

// Insert data into the database
try {
    $stmt = $db->prepare("INSERT INTO recieved (ADNO, img, img_name) VALUES (:admissionNumber, :img, :imgName)");
    foreach ($uploadedFiles as $filename) {
        $stmt->bindParam(':admissionNumber', $admissionNumber);
        $stmt->bindParam(':img', $filename);
        $stmt->bindParam(':imgName', $imgName);
        $stmt->execute();
    }

    //echo "Data inserted successfully.";
      // Send SMS after successful upload using Savvy Bulk SMS API
    $partnerID = '8854';
    $mobile = '254722902865'; // Replace with the teacher's phone number
    $apikey = '70efa65617bcc559666d74e884c3abb6';
    $shortcode = 'Savvy_sms';
    $message = "New upload from ADNO: $admissionNumber CAT/EXAMINATION:$imgName  at " . date('Y-m-d H:i:s');

    // Construct the URL with parameters
    $url = 'https://sms.savvybulksms.com/api/services/sendsms';
    $url .= '?partnerID=' . urlencode($partnerID);
    $url .= '&mobile=' . urlencode($mobile);
    $url .= '&apikey=' . urlencode($apikey);
    $url .= '&shortcode=' . urlencode($shortcode);
    $url .= '&message=' . urlencode($message);

    // Make a GET request to the Savvy Bulk SMS API
    file_get_contents($url); // This will send the SMS

    // Redirect to another page after successful upload and SMS sending
   // header("Location: UPLOADSTU.php");
      $nairobiTime = date('Y-m-d H:i:s');
     $successMessage = urlencode("Upload successful! ADNO: $admissionNumber, Time: $nairobiTime");
    header("Location: UPLOADSTU.php?adno=$admissionNumber&message=$successMessage");
    
    

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
    exit; // Ensure that no further code is executed after the redir
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
