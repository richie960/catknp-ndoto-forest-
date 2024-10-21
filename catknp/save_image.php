<?php
// Get the adno from the URL parameter
if (isset($_GET['adno'])) {
    $adno_parts = $_GET['adno'];
    // Transform slashes and hyphens to match the filename format
    $adno = str_replace('/', '-', $adno_parts); 
} else {
    echo "Adno parameter is missing.";
    exit(); // Stop further execution
}

// Specify the folder containing the images
$image_folder = 'up/';

// Check if the image folder exists
if (!is_dir($image_folder)) {
    echo "Image folder does not exist.";
    exit();
}

// Get all the image files in the folder
$image_files = glob($image_folder . '*.png');

echo "Formatted Adno: $adno <br>"; // Debugging

if (!empty($image_files)) {
    // Display links to access the images that match the adno
    foreach ($image_files as $image_path) {
        $image_name = basename($image_path);
        $image_adno = substr($image_name, 0, 12); // Extract the relevant part from the image name
        echo "Image Adno Part: $image_adno <br>"; // Debugging
        if ($image_adno === $adno) {
            echo "<a href='$image_path'><img src='$image_path' style='width: 100px; height: auto;' /></a> $image_name<br>";
        }
    }
} else {
    // No images found
    echo "No images found in the folder.";
}
?>
