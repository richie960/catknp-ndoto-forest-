<?php
// File path where the password is stored
$passwordFilePath = 'password.txt';

// Generate a new password (replace this with your own logic)
$newPassword = password_hash('new_password', PASSWORD_DEFAULT);

// Update the password in the file
if (file_put_contents($passwordFilePath, $newPassword) !== false) {
 //   echo "Password updated successfully!";
} else {
    echo "Error updating password. Check file permissions.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text File Display</title>
    <style>
        body {
            background-color: #282c34;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        #cardContainer {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 80%; /* Increased width */
            margin: auto;
        }

        #contentContainer {
            color: #333;
            position: relative;
            margin-bottom: 20px;
        }

        #refreshSpinner {
            width: 50px;
            height: 50px;
            border: 6px solid transparent;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            margin-top: 20px; /* Adjust the margin as needed */
            margin-left: auto;
            margin-right: auto;
            display: block;
            cursor: pointer;
            animation: rotate 10s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); border-color: #3498db; }
            25% { border-color: #e74c3c; }
            50% { border-color: #2ecc71; }
            75% { border-color: #f39c12; }
            100% { transform: rotate(360deg); border-color: #3498db; }
        }

        #copyButton {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="cardContainer">
        <div id="contentContainer">
            <?php
            // File path where the content is stored
            $filePath = 'password.txt';

            // Read and display the content of the text file
            $content = file_get_contents($filePath);
            echo nl2br($content);
            ?>
        </div>
        <button id="copyButton" onclick="copyText()">Copy password</button>
        <div id="refreshSpinner" onclick="refreshPage()"></div>
    </div>

    <script>
        // Function to refresh the page
        function refreshPage() {
            // Trigger a page refresh after a short delay
            setTimeout(function() {
                location.reload(true);
            }, 1000);
        }

        // Function to copy text to clipboard
        function copyText() {
            var contentContainer = document.getElementById('contentContainer');
            var textToCopy = contentContainer.innerText;

            // Create a temporary textarea to hold the text
            var tempTextarea = document.createElement('textarea');
            tempTextarea.value = textToCopy;
            document.body.appendChild(tempTextarea);

            // Select and copy the text
            tempTextarea.select();
            document.execCommand('copy');

            // Remove the temporary textarea
            document.body.removeChild(tempTextarea);

            alert('Text copied to clipboard!');
        }
    </script>

    
</body>
</html>
