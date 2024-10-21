<?php
// Check if latitude and longitude are set
if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Create or open the text file for writing
    $file = fopen('coordinates.txt', 'w');

    // Write coordinates to the text file
    fwrite($file, "Latitude: $latitude, Longitude: $longitude");

    // Close the file
    fclose($file);

    echo 'Coordinates saved successfully.';
} else {
    echo 'Error: Latitude and longitude are not set.';
}
?>
