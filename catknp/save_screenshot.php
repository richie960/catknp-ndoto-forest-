<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the image data is received
if(isset($_POST['imgData']) && !empty($_POST['imgData'])) {
    // Get the image data
    $imgData = $_POST['imgData'];

    // Log received image data (for debugging)
    file_put_contents('received_image_data.txt', $imgData);

    // Validate the image data
    if(strpos($imgData, 'data:image/png;base64,') !== false) {
        // Generate a unique filename
        $filename = 'edited_images/screenshot_' . uniqid() . '.png';

        // Log generated filename (for debugging)
        file_put_contents('generated_filename.txt', $filename);

        // Save the image data to a file
        if(file_put_contents($filename, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgData)))) {
            // Return the filename back to JavaScript
            echo $filename;
        } else {
            echo 'Error: Unable to save screenshot.';
        }
    } else {
        echo 'Error: Invalid image data format.';
    }
} else {
    echo 'Error: No image data received.';
}
?>
