<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Upload Form</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Upload PDF</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="pdfFile">Choose a PDF file:</label>
            <input type="file" name="pdfFile" id="pdfFile" accept=".pdf" required>

            <label for="pdfName">PDF Name:</label>
            <input type="text" name="pdfName" id="pdfName" placeholder="eg.cat 1, cat 2 " required>

            <button type="submit" name="submit">Upload PDF</button>
        </form>

        <?php
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            echo '<div class="' . $status . '">' . ucfirst($status) . ' upload!</div>';
        }
        ?>
    </div>
</body>

</html>

<br>
<br>
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