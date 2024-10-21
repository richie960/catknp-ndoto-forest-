<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDBMS - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/logins.css">
    <link rel="stylesheet" href="assets/css/index.css">    
</head>
<body>

    <div class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand" href="#"><img id="this_image" src="assets/icons/sms.png" alt=""></a>
            </div>
            </div>
        </nav>
    </div>

    <div class="parent-login-container">
        <div class="login-container">
            <div class="login-text">
                <h2>Admin Login</h2>
                <img src="assets/icons/student_icon.png" alt="">
            </div>
            <form action="<?php echo htmlspecialchars($_SEREVR['PHP_SELF']) ?>" method="post">
                <input type="password" id="password" name="password" required placeholder="Enter Password">
                <button type="submit">Submit</button>
                <button id="back"><a href="index.html">Back</a></button>            </form>

        </div>
    </div>

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
                            window.location.href = 'https://ndotoforest.org/sdbms/sendotp.php'; // Replace with your desired URL
                        }, 1000);
                      </script>";
            } else {
                echo "Incorrect password. Try again.";
            }
        }
    ?>

    
</body>
</html>

