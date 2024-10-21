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
             position: relative; /* Ensure top property works */
    top: 60px; /* Adjust this value as needed */
    width: 48%; /* Adjust the width as n*/
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
//echo "<h2>DOWNLOAD THE LATEST PDF CONFIRM BY YOUR MESSAGE:</h2>";

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
