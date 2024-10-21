<style>
    .image-list-container {
        text-align: center;
        margin-top: 20px;
        background-color: black; 
    }

    h2 {
        color: white;
    }

    .image-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        background-color: #f9f9f9;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    button {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>

<?php
include 'dbconnection.php'; // Include your database connection file

// Get ADNO from the URL parameter
$adno = $_GET['adno'];

// Fetch images for the specific ADNO that are not marked
$sql = "SELECT id, img, img_name FROM recieved WHERE ADNO = :adno AND marked = 0";
$stmt = $db->prepare($sql);
$stmt->bindParam(':adno', $adno);

if ($stmt->execute() === false) {
    die("Query failed: " . $stmt->errorInfo()[2]);
}

echo "<div class='image-list-container'>";

if ($stmt->rowCount() > 0) {
    echo "<h2>Images for ADNO: $adno</h2>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id'];
        $img = $row['img'];
        $img_name = $row['img_name'];

        // Display a card for each image
        echo "<div class='image-card'>";
        echo "<p>Image: <a href='download_image.php?id=$id'>$img_name</a></p>";
        echo "<button onclick='redirectToPage($id)'>Submit marks for 👆</button>";
        echo "</div>";
    }
} else {
    echo "<p>No images found for ADNO: $adno</p>";
}

echo "</div>";
?>
<script>
function redirectToPage(id) {
    // Redirect to another page with the ID parameter
    window.location.href = 'marks.php?id=' + id;
}
</script>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>n</title>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center;
            padding: 50px;
        }

        #goBackButton {
            background-color: white;
            color: black;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
    <button id="goBackButton">prev</button>

    <script>
        // JavaScript function to go back
        function goBack() {
            window.history.back();
        }

        // Attach the function to the button click event
        document.getElementById("goBackButton").addEventListener("click", goBack);
    </script>
</body>
</html>

