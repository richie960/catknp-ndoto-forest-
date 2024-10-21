<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }

        .go-back-btn {
            position: fixed;
            z-index: 9999; /* Ensure the button appears above other elements */
            top: 20px;
            left: 20px;
            background-color: white; /* White background */
            border: 2px solid black;
            color: black; /* Black text */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 8px; /* Harmonized edges */
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth hover effect */
        }

        .go-back-btn:hover {
            background-color: black; /* Black background on hover */
            color: white; /* White text on hover */
        }

        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end; /* Align images from right to left */
            gap: 10px;
            padding: 100px 10px 20px 10px; /* Add padding top for space for the button */
        }

        .image-container {
            text-align: center; /* Center align the content in each container */
        }

        .image-gallery img {
            width: 100px;
            height: auto;
            border: 2px solid #ddd;
            border-radius: 5px;
            display: block; /* Make images block elements */
            margin: 0 auto; /* Center images horizontally */
        }

        .view-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            margin-top: 10px;
        }

        #fullImageContainer {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            text-align: center;
        }

        #fullImage {
            max-width: 90%;
            max-height: 90%;
            margin-top: 5%;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <button class="go-back-btn" onclick="goBack()">Go Back</button>

    <div class="image-gallery">
        <?php
        // Include the database connection file
        include 'dbconnection.php';

        // Get the adno from the URL parameter
        if (isset($_GET['adno'])) {
            $adno = $_GET['adno'];
        } else {
            echo "Adno parameter is missing.";
            exit(); // Stop further execution if adno is not provided
        }

        // Prepare the SQL statement
        $sql = "SELECT filename FROM saved_images WHERE adno = :adno";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':adno', $adno, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch all matching filenames
        $filenames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Specify the folder containing the images
        $image_folder = 'up/';

        // Check if any filenames were found
        if (!empty($filenames)) {
            foreach ($filenames as $filename) {
                $image_path = $image_folder . $filename;
                if (file_exists($image_path)) {
                    echo "<div class='image-container'>";
                    echo "<a href=''><img src='$image_path?v=" . time() . "' alt='$filename' /></a>";
                    echo "<button class='view-button' onclick='showFullImage(\"$image_path?v=" . time() . "\")'>View Full Image</button>";
                    echo "</div>";
                }
            }
        } else {
            echo "No images found for adno $adno.";
        }
        ?>
    </div>

    <!-- Script to show full-size image -->
    <script>
    function goBack() {
        window.history.back();
    }

    function showFullImage(imagePath) {
        var fullImageContainer = document.getElementById('fullImageContainer');
        var fullImage = document.getElementById('fullImage');
        fullImage.src = imagePath;
        fullImageContainer.style.display = 'block';
    }

    function hideFullImage() {
        var fullImageContainer = document.getElementById('fullImageContainer');
        fullImageContainer.style.display = 'none';
    }
    </script>

    <!-- Container to display full-size image -->
    <div id="fullImageContainer">
        <img id="fullImage" alt="Full Image">
        <button class="close-button" onclick="hideFullImage()">Close</button>
    </div>
</body>
</html>
