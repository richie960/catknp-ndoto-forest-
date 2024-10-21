<?php
// Include the database connection file
include 'dbconnection.php';

try {
    // Query to calculate total sms_count
    $sql_total_sms_count = "SELECT SUM(sms_count) AS total_sms_count FROM logins";
    $stmt_total_sms_count = $db->prepare($sql_total_sms_count);
    $stmt_total_sms_count->execute();
    $row_total_sms_count = $stmt_total_sms_count->fetch(PDO::FETCH_ASSOC);
    $total_sms_count = $row_total_sms_count['total_sms_count'];
    
    // Determine if payment reminder is needed
    $payment_reminder = '';
    if ($total_sms_count > 500) {
        $payment_reminder = '<div style="color: red;">Payment reminder: Please settle outstanding balance.</div>';
    }
} catch (PDOException $e) {
    $total_sms_count = "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS Count</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: black;
    color: white; /* Set text color to white */
}

.container {
    text-align: center;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>PAYMENT NEEDED</h1>
        <p>KSH: <?php echo $total_sms_count; ?></p>
        <?php echo $payment_reminder; ?>
        
    </div>


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