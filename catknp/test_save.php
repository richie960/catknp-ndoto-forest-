
<?php
include 'dbconnection.php';
 
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the image data, adno, and id from the POST data
    $imageData = $_POST["imageData"];
    $adno = $_POST["adno"];
    $id = $_POST["id"];

    // Remove the data prefix
    $imageData = str_replace('data:image/png;base64,', '', $imageData);
    $imageData = str_replace(' ', '+', $imageData);

    // Decode the base64 encoded image data
    $imageData = base64_decode($imageData);

    // Set the file path to save the image
    $directory = 'up/';
    $extension = '.png';
    $adnoFile = str_replace('/', '-', $adno); 

    $filename = $adnoFile . $extension;
    $filepath = $directory . $filename;
    
    $counter = 1;
    while (file_exists($filepath)) {
        $filename = $adnoFile . '_' . $counter . $extension; // Add underscore before the counter
        $filepath = $directory . $filename; // Update $filepath with the new filename
        $counter++;
        
        // Add a condition to prevent infinite loops
        if ($counter > 1000) {
            http_response_code(500); // Internal Server Error
            echo json_encode(array("success" => false, "message" => "Error: Too many iterations in file naming."));
            exit; // Exit the script
        }
    }

    // Save the image data to the file
    $file = fopen($filepath, 'wb');
    fwrite($file, $imageData);
    fclose($file);
    
    // Insert adno, filename, and id into the database
    $sql = "INSERT INTO saved_images (adno, filename, idr) VALUES (:adno, :filename, :id)";
    $stmt = $db->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':adno', $adno);
    $stmt->bindParam(':filename', $filename);
    $stmt->bindParam(':id', $id);
    
    // Execute the statement
    try {
        $stmt->execute();
        echo json_encode(array("success" => true, "message" => "Image saved successfully"));
    } catch (PDOException $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
    }
} else {
    // If request method is not POST, return an error response
    http_response_code(405);
    echo json_encode(array("success" => false, "message" => "Method not allowed"));
}
?>