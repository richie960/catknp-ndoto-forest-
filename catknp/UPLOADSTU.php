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
             position: fixed; /* Ensure top property works */
    top: 50px; /* Adjust this value as needed */
    width: 48%; /* Adjust the width as n*/
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        form {
             position: relative; /* Ensure top property works */
    top: 50px; /* Adjust this value as needed */
    width: 48%; /* Adjust the width as n*/
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
    <?php
// Check if the 'adno' parameter is present in the URL
if (isset($_GET['adno'])) {
    // Retrieve the 'adno' parameter from the URL
    $adno = $_GET['adno'];
    
    // Now you can use the $adno variable in your script
  //  echo "The adno is: " . htmlspecialchars(c);
} else {
    // Handle the case where 'adno' is not present in the URL
  //  echo "No adno parameter found in the URL.";
}
?>

</head>
<body>
    
    <form action="upload2.php" method="post" enctype="multipart/form-data">
        <label for="admission_number">Admission Number (ADNO):</label>
        <input type="text" name="admission_number" value="<?php  echo $adno ?>" readonly required>

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
