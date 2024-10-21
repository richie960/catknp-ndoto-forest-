<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Images</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: #333;
        }

        h2 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Upload rough work  images</h2>
    <form action="upload2.php" method="post" enctype="multipart/form-data">
        <label for="admission_number">Admission Number (ADNO):</label>
        <input type="text" name="admission_number" placeholder="eg. ICT/600/S22/001" required>

        <label for="img_name">Assignment Name:</label>
        <input type="text" name="img_name" placeholder="Name it as the pdf you downloaded"  required>

        <label for="images">Upload Image(s):</label>
        <input type="file" name="images[]" accept="image/*" multiple required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

<br>
<br>
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
    <title>Display Message from URL</title>
    <style>
    #messageBox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        display: none;
        transition: opacity 1s ease-in-out;
    }

    #messageBox.success {
        background-color: green;
        color: white;
    }

    #messageBox.error {
        background-color: red;
        color: white;
    }
    </style>
</head>

<body>

    <?php
// Extract the message from the URL
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Determine if the message contains the word "not"
$hasNot = stripos($message, 'not') !== false;

// Apply the class based on the presence of "not"
$class = $hasNot ? 'error' : 'success';

echo "<div id='messageBox' class='$class'>$message</div>";
?>

    <script>
    // JavaScript to display the message box
    document.addEventListener("DOMContentLoaded", function() {
        var messageBox = document.getElementById('messageBox');
        if (messageBox) {
            messageBox.style.display = 'block';
            setTimeout(function() {
                messageBox.style.opacity = 0;
            }, 10000);
        }
    });
    </script>

</body>

</html>
