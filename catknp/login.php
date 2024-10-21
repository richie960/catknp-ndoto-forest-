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
            header("Location: https://ndotoforest.org/catknp/darkpan-1.0.0/index.php?adno=$adno");
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
                    header("Location: https://ndotoforest.org/catknp/darkpan-1.0.0/index.php?adno=$adno");
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
    <title>Insert ADNO and PhoneNumber</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: black;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
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
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Insert ADNO and PhoneNumber</h2>
        <form action="" method="post">
            <label for="adno">ADNO:</label>
            <input type="text" name="adno" value="<?php echo htmlspecialchars($adno); ?>" placeholder="egICT/600/S33/018 "required>

            <label for="phonenumber">PhoneNumber:</label>
            <input type="text" name="phonenumber" value="<?php echo htmlspecialchars($phonenumber); ?>" placeholder="eg 0712345678,254712345678" required>

            <button type="submit">Submit</button>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        </form>
    </div>
</body>
</html>
