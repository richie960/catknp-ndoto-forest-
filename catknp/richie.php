<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload YouTube Links</title>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center;
            padding: 50px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        textarea {
            resize: vertical;
        }

        #submitButton {
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

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $youtubeLink = $_POST['youtubeLink'];
    $explanation = $_POST['explanation'];

    // Format the data
    $data = $youtubeLink . " | " . $explanation . "\n";

    // Open the file and append the data
    $file = 'test.txt';
    $current = file_get_contents($file);
    $current .= $data;

    // Write the contents back to the file
    file_put_contents($file, $current);

    echo "<p>Link and explanation uploaded successfully!</p>";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="youtubeLink">YouTube Link:</label><br>
    <input type="text" id="youtubeLink" name="youtubeLink" required><br>
    <label for="explanation">Explanation:</label><br>
    <textarea id="explanation" name="explanation" rows="4" required></textarea><br>
    <input type="submit" value="Submit" id="submitButton">
</form>



</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Back Button Example</title>
    <style>
        .go-back-btn {
            position: fixed;
            z-index: 9999; /* Ensure the button appears above other elements */
            top: 20px;
            left: 20px; /* Changed to left to position at the top left corner */
            background-color: white; /* Green */
            border: none;
            color: black;
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
            background-color: black; /* Darker green on hover */
            color:white;
        }
    </style>
</head>
<body>
    <button class="go-back-btn" onclick="goBack()">Go Back</button>
    
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
