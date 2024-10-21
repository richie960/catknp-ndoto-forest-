<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Back Button</title>
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
    
    <button id="goBackButton">Go Back</button>

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




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download PDFs</title>
    <style>
        body {
            background-color: black;
            color: white; /* Set text color to white for better visibility on black background */
        }

        .pdf-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
            display: flex;
            align-items: center;
            background-color: white;
        }

        img {
            margin-right: 5px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
// Specify the directory where PDF files are stored (assuming both script and PDFs are in the root)
$pdfDirectory = './';

// Get the list of PDF files in the directory
$pdfFiles = glob($pdfDirectory . '/*.pdf');

// Display HTML for each PDF file
echo "<h2>DOWNLOAD THE LATEST PDF CONFIRM BY YOUR MESSAGE:</h2>";

foreach ($pdfFiles as $pdfFile) {
    // Extract the filename without the path
    $pdfFilename = basename($pdfFile);

    // Display each link in a separate card
    echo "<div class='pdf-card'>";
    echo "<img src='https://ndotoforest.org/catknp/download.png' alt='' height='16' width='16'>";
    echo "<a href='fir.php?filename=" . urlencode($pdfFilename) . "'>" . $pdfFilename . "</a>";
    echo "</div>";
}

?>
</body>
</html>
