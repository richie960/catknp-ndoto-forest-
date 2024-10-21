<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Images</title>
</head>
<body>
<div class="container">
    <h1>Edit Images</h1>
    <div class="edit-form">
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        require_once('dbconnection.php');

        // Retrieve all images from the database
        $query = "SELECT id, img FROM recieved";
        $result = $db->query($query);

        // Check if the query was executed successfully
        if (!$result) {
            echo "Error: Unable to fetch images.";
        } else {
            // Check if there are any images in the result set
            if ($result->rowCount() > 0) {
                // Display the images in HTML
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    // Output the image using base64-encoded data
                    $imageData = base64_encode($row['img']);
                    echo '<img src="data:image/jpeg;base64,'. $imageData .'" alt="Image">';
                }
            } else {
                // No images found in the database
                echo "No images found in the database.";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
