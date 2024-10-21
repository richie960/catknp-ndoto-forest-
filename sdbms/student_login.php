<?php
// Include the database connection file
include 'dbconnection.php';

// Initialize variables
$adno = '';
$phonenumber = '';
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values and validate
    $adno = filter_input(INPUT_POST, 'adno', FILTER_SANITIZE_STRING);
    $phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_STRING);

    // Validate admission number format
    if (!preg_match('/^[A-Z]+\/[0-9]+\/[A-Z]+[0-9]+\/[0-9]+$/', $adno)) {
        $errorMessage = "Invalid admission number format. Please use the format like ABC/123/S22/023";
    } elseif (empty($phonenumber)) {
        $errorMessage = "Please provide a phone number.";
    } elseif (strlen($phonenumber) < 10 || strlen($phonenumber) > 12 || !ctype_digit($phonenumber)) {
        $errorMessage = "Phone number should have a minimum of 10 digits and a maximum of 12 digits.";
    } else {
        // Check if the combination of ADNO and phonenumber exists in one row
        $sql_check = "SELECT * FROM logins WHERE ADNO = :adno AND phonenumber = :phonenumber";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->bindParam(':adno', $adno, PDO::PARAM_STR);
        $stmt_check->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $stmt_check->execute();

        if ($stmt_check->rowCount() == 1) {
            // Combination exists, proceed to another page with ADNO in the URL
            header("Location: https://ndotoforest.org/sdbms/admin_panel.php?adno=$adno");
            exit;
        } else {
            // Check if the phone number already exists in the database
            $sql_check_phonenumber = "SELECT * FROM logins WHERE phonenumber = :phonenumber";
            $stmt_check_phonenumber = $db->prepare($sql_check_phonenumber);
            $stmt_check_phonenumber->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
            $stmt_check_phonenumber->execute();

            if ($stmt_check_phonenumber->rowCount() == 0) {
                // Phone number doesn't exist, insert new row
                $sql_insert = "INSERT INTO logins (ADNO, phonenumber) VALUES (:adno, :phonenumber)";
                $stmt_insert = $db->prepare($sql_insert);
                $stmt_insert->bindParam(':adno', $adno, PDO::PARAM_STR);
                $stmt_insert->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);

                if ($stmt_insert->execute()) {
                    // Data inserted successfully, redirect to another page with ADNO in the URL
                    header("Location: https://ndotoforest.org/sdbms/admin_panel.php?adno=$adno");
                    exit;
                    
                    
                } else {
                  $errorMessage = "Error inserting data.";
                }
            } else {
                $errorMessage = "Phone number already exists in the database.";
            }
        }
    }
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDBMS - Student Login</title>
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
                <h2>Student Login</h2>
                <img src="assets/icons/student_icon.png" alt="">
            </div>
            <form action="" method="post">
                <input type="text" name="adno" value="<?php echo htmlspecialchars($adno); ?>" placeholder="ADNO eg:ICT/600/S33/018 "required>
    
                <input type="text" name="phonenumber"  value="<?php echo htmlspecialchars($phonenumber); ?>" placeholder="Phone NO: 0712345678" required>
    
                <button type="submit">Submit</button>
                <button id="back"><a href="index.html">Back</a></button>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            </form>
        </div>
    </div>
</body>
</html>