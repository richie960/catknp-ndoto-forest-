<?php

include 'dbconnection.php';
 
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the image data and adno from the POST data
    $imageData = $_POST["imageData"];
    $adno = $_POST["adno"];

    // Remove the data prefix
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);

    // Decode the base64 encoded image data
    $imageData = base64_decode($imageData);

    // Set the file path to save the image
    $directory = 'up/';
    $adnoFile = str_replace('/', '-', $adno); 
    $filename = $adnoFile;
    $filepath = $directory . $filename;
    
    // Check if the file exists
    if (file_exists($filepath)) {
        // Delete the existing file
        unlink($filepath);
    }
    
    // Save the image data to the file
    $file = fopen($filepath, 'wb');
    fwrite($file, $imageData);
    fclose($file);
    
    // Return success response
    echo json_encode(array("success" => true, "message" => "Image saved successfully"));
} else {
    // If request method is not POST, return an error response
    http_response_code(405);
    echo json_encode(array("success" => false, "message" => "Method not allowed"));
}
