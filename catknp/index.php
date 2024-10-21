
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Links</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
           background-color:black;
        }

   .pdf-card {
    position: relative; /* Ensure top property works */
    top: 70px; /* Adjust this value as needed */
    width: 48%; /* Adjust the width as needed */
    box-sizing: border-box;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    display: inline-block;
    background-color: white;
}


        img {
            margin-right: 5px;
            width: 20px;
            height: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
       > }
    </style>
</head>
<body>

<?php
// Include the database connection file
include 'dbconnection.php';

// Fetch data from the database
$sql = "SELECT id, pdf, pdfname FROM cat";
$stmt = $db->query($sql);

// Check if there are rows in the result
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Display download link with associated name
        echo "<div class='pdf-card'>";
        echo "<img src='https://ndotoforest.org/catknp/download.png' alt='PDF icon' width='20' height='20'>";
        echo "<a href='download.php?id={$row['id']}'>" . $row['pdfname'] . "</a>";
        echo "</div>";
    }
} else {
    echo "No PDFs found in the database.";
}
?>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .message-box {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            color: white;
            font-weight: bold;
            display: none;
            transition: background-color 0.5s;
        }

        .green {
            background-color: green;
        }

        .red {
            background-color: red;
        }
    </style>
</head>
<body>
    <div id="messageBox" class="message-box"></div>

    <script>
        // Function to parse URL parameters
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Function to display message box
        function displayMessageBox(message, isError) {
            var messageBox = document.getElementById("messageBox");
            messageBox.textContent = message;

            if (isError) {
                messageBox.classList.remove("green");
                messageBox.classList.add("red");
            } else {
                messageBox.classList.remove("red");
                messageBox.classList.add("green");
            }

            messageBox.style.display = "block";

            // Hide the message box after 3 seconds
            setTimeout(function() {
                messageBox.style.display = "none";
            }, 5000);
        }

        // Read information from the URL
        var infoFromURL = getParameterByName("message");

        // Display message box based on the information
        if (infoFromURL !== null) {
            displayMessageBox("Received information: " + infoFromURL, false);
        } else {
            displayMessageBox("No information in the URL", true);
        }
    </script>
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
<br>>