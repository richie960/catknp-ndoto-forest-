<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            transition: background-color 0.5s ease;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
        }

        input {
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .rotating-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 3px solid #ff0000;
            border-top: 3px solid transparent;
            animation: rotate 1s linear infinite;
            margin-top: 20px;
            display: none;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="password">Enter Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Submit</button>
    </form>

    <div class="rotating-circle" id="rotatingCircle"></div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = htmlspecialchars($_POST["password"]);
    
    // Sanitize against SQL injection
    $user_input = filter_var($user_input, FILTER_SANITIZE_STRING);
    
    // Read the correct password from the file
    $correct_password = file_get_contents("password.txt");

    if (trim($user_input) == trim($correct_password)) {
        // Password matched, show rotating circle for 5 seconds
        echo "<script>
                document.getElementById('rotatingCircle').style.display = 'block';
                setTimeout(function(){
                    document.body.style.backgroundColor = '#000';
                    // Redirect to another URL after 5 seconds
                    window.location.href = 'https://ndotoforest.org/catknp/darkpan-1.0.0/index5c.php'; // Replace with your desired URL
                }, 5000);
              </script>";
    } else {
        echo "Incorrect password. Try again.";
    }
}
?>



</div>

</body>
</html>
<?php
// Parameters
$partnerID = '8854';
$mobile = '254746465349';
$apikey = '70efa65617bcc559666d74e884c3abb6';
$shortcode = 'Savvy_sms';
$message = 'test cheking validity for promotional messages';

// Construct the URL with parameters
$url = 'https://sms.savvybulksms.com/api/services/sendsms';
$url .= '?partnerID=' . urlencode($partnerID);
$url .= '&mobile=' . urlencode($mobile);
$url .= '&apikey=' . urlencode($apikey);
$url .= '&shortcode=' . urlencode($shortcode);
$url .= '&message=' . urlencode($message);

// Redirect to the constructed URL
header("Location: $url");
exit; // Ensure that no further code is executed after the redirect
?>
