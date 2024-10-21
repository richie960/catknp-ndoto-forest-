<?php

include 'dbconnection.php';

// Initialize variables for search
$searchResults = [];
$searchedAdno = '';
$searchedDate = '';

// Check if the search form is submitted
if (isset($_GET['search'])) {
    // Get the searched adno and date
    $searchedAdno = isset($_GET['adno']) ? $_GET['adno'] : '';
    $searchedDate = isset($_GET['date']) ? $_GET['date'] : '';

    // Build the SQL query with optional filters
    $sql = "SELECT id, filename FROM saved_images WHERE 1=1";
    if (!empty($searchedAdno)) {
        $sql .= " AND adno = :adno";
    }

    $stmt = $db->prepare($sql);
    
    // Bind parameters if they are set
    if (!empty($searchedAdno)) {
        $stmt->bindParam(':adno', $searchedAdno);
    }

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Filter results by date if provided
    if (!empty($searchedDate)) {
        $searchResults = array_filter($searchResults, function($image) use ($searchedDate) {
            $filename = 'up/' . $image['filename'];
            if (file_exists($filename)) {
                $fileModificationTime = filemtime($filename);
                $fileDate = date('Y-m-d', $fileModificationTime);
                return strpos($fileDate, $searchedDate) !== false;
            }
            return false;
        });
    }
} else {
    // Fetch all images if no search is performed
    $sql = "SELECT id, filename FROM saved_images";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Search</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label, input, button {
            display: block;
            margin-bottom: 10px;
        }
        input, button {
            padding: 10px;
            border-radius: 4px;
            border: none;
        }
        input {
            width: 200px;
        }
        button {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .image-container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .image-box {
            margin: 0 20px 20px 0;
            flex: 0 0 calc(33.33% - 20px);
            max-width: calc(33.33% - 20px);
        }
        .image-box img {
            max-width: 100%;
            display: block;
            margin-bottom: 10px;
        }
        .image-box p {
            margin-top: 0;
        }
        .go-back-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: white;
            border: none;
            color: black;
            padding: 10px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            cursor: pointer;
        }
        .go-back-button:hover {
            background-color: black;
            color:white;
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
        @media screen and (max-width: 768px) {
            .image-box {
                flex: 0 0 calc(50% - 20px);
                max-width: calc(50% - 20px);
            }
        }
        @media screen and (max-width: 480px) {
            .image-box {
                flex: 0 0 calc(100% - 20px);
                max-width: calc(100% - 20px);
            }
        }
    </style>
</head>
<body>

<button class="go-back-button" onclick="window.location.href='https://ndotoforest.org/sdbms/admin_teach.php';">Home</button>


<form method="GET">
    <label for="adno">Search by Adno:</label>
    <input type="text" id="adno" name="adno" value="<?php echo htmlspecialchars($searchedAdno); ?>">
    <label for="date">Search by Date (YYYY-MM or YYYY-MM-DD):</label>
    <input type="text" id="date" name="date" value="<?php echo htmlspecialchars($searchedDate); ?>">
    <button type="submit" name="search">Search</button>
</form>

<div class="image-container">
<?php
// Display search results or all images
foreach ($searchResults as $image) {
    $id = $image['id'];
    $filename = $image['filename'];
    $imagePath = 'up/' . $filename;

    if (file_exists($imagePath)) {
        // Get the file's last modification time
        $fileModificationTime = filemtime($imagePath);
        // Format the date to a readable format, e.g., 'F d, Y'
        $formattedDate = date('F d, Y', $fileModificationTime);

        echo '<div class="image-box">';
        echo '<img src="' . $imagePath . '?v=' . time() . '" alt="Image ' . $id . '">';
        echo '<p>Saved or modified on: ' . $formattedDate . '</p>';
        echo '<button onclick="showFullImage(\'' . $imagePath . '?v=' . time() . '\')">View Full Image</button>';
        echo '<a href="https://ndotoforest.org/catknp/teachers.php?id=' . $id . '" style="background-color: #4CAF50; border: none; color: white; padding: 10px 24px; text-align: center; text-decoration: none; display: inline-block; border-radius: 4px; margin-left: 10px;">Remark</a>';
        echo '</div>';
    }
}
?>
</div>

<!-- Script to show full-size image -->
<script>
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
    <button onclick="hideFullImage()" style="position: absolute; top: 10px; right: 10px; background-color: #4CAF50; border: none; color: white; padding: 10px 24px; text-align: center; text-decoration: none; display: inline-block; border-radius: 4px;">Close</button>
</div>

</body>
</html>


<?php
// Check if the 'message' parameter exists in the URL
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Message</title>
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #4CAF50;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<?php if ($message): ?>
    <div id="message" class="message">
        <?php echo htmlspecialchars($message); // Sanitize the message to prevent XSS ?>
    </div>
    <script>
        // Hide the message after 5 seconds (5000 milliseconds)
        setTimeout(function() {
            var messageDiv = document.getElementById('message');
            if (messageDiv) {
                messageDiv.style.display = 'none';
            }
        }, 5000);
    </script>
<?php endif; ?>

<!-- Your existing content goes here -->

</body>
</html>

