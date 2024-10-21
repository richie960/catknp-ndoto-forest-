<?php
// Check if latitude, longitude, and name are set in the POST request
if (isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['name'])) {
    // Assign POST values to variables
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $name = $_POST['name'];

    // Save the received data to a text file
    $data = "Latitude: $latitude, Longitude: $longitude, Name: $name\n";
    file_put_contents('coordinates.txt2', $data, FILE_APPEND);

    // Echo success message
    echo "Coordinates saved successfully.";
} else {
    // If any of the required POST parameters are missing, echo an error message
    echo "Error: Latitude, longitude, or name not set.";
}

// Output all the data ever stored in the text file
$allData = file_get_contents('coordinates.txt');
echo "<pre>$allData</pre>";
echo "no data";
?>
