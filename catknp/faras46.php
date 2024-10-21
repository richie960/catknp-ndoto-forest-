<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }

        input {
            margin-top: 5px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #message {
            margin-top: 20px;
            color: red;
        }
        
        .check-progress-btn {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
}

.check-progress-btn:hover {
    background-color: #0056b3;
}

    </style>
<a href="faras47.php" class="check-progress-btn">Check Progress</a>

    
</head>
<body>
    <div class="form-container">
        <form id="userForm" action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
            
            <label for="referral">Referral:</label>
            <input type="text" id="referral" name="referral">
            
            <label for="referrer">Referrer Name:</label>
            <input type="text" id="referrer" name="referrer">
            
            <button type="submit">Submit</button>
            <p id="message"></p>
        </form>
    </div>
   <script>
        function submitForm() {
            const form = document.getElementById('userForm');
            const formData = new FormData(form);
            
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const message = document.getElementById('message');
                if (data.success) {
                    message.style.color = 'green';
                } else {
                    message.style.color = 'red';
                }
                message.textContent = data.message;
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'dbconnection.php';

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $referral = $_POST['referral'];
    $referrer = $_POST['referrer'];

    // Prepare and execute a query to check if the phone number already exists
    $sql_check = "SELECT * FROM users WHERE phone = ?";
    $stmt_check = $db->prepare($sql_check);
    $stmt_check->execute([$phone]);
    $result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

    // If the phone number already exists, return an error message
    if ($result_check) {
        $response = array("success" => false, "message" => "Phone number already exists.");
    } else {
        // Prepare and execute a query to insert new user data
        $sql_insert = "INSERT INTO users (name, phone, referral, referrer) VALUES (?, ?, ?, ?)";
        $stmt_insert = $db->prepare($sql_insert);
        
        if ($stmt_insert->execute([$name, $phone, $referral, $referrer])) {
            //$response = array("success" => true, "message" => "Data inserted successfully.");
        } else {
            $errorInfo = $stmt_insert->errorInfo();
          //  $response = array("success" => false, "message" => "Error inserting data: " . $errorInfo[2]);
        }
    }

    // Close the prepared statements and the database connection
    $stmt_check->closeCursor();
    $stmt_insert->closeCursor();
    $db = null;

    // Return JSON response
 //   echo json_encode($response);
    exit();
}
?>


