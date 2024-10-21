<!DOCTYPE html>
<html>
<head>
    <title>User Filter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type=text], input[type=date], input[type=submit] {
            margin-bottom: 10px;
            padding: 5px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }
        .back-btn {
            background-color: #f44336;
            color: white;
            cursor: pointer;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>

<h2>User Filter</h2>

<form method="GET" action="">
    <label for="referrer">Referrer:</label><br>
    <input type="text" id="referrer" name="referrer"><br>
    
    <label for="date">Date:</label><br>
    <input type="date" id="date" name="date"><br>
    
    <input type="submit" value="Filter">
</form>

<?php
require 'dbconnection.php';

// Define filters
$referrer = isset($_GET['referrer']) ? $_GET['referrer'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Prepare the SQL query
$sql = "SELECT * FROM users WHERE 1=1"; // Always true to allow appending conditions

// Add filters if provided
$params = array();
if (!empty($referrer)) {
    $sql .= " AND referrer = :referrer"; // Corrected column name
    $params[':referrer'] = $referrer;
}
if (!empty($date)) {
    $sql .= " AND DATE(date) = :date"; // Extracting date part from datetime
    $params[':date'] = $date;
}

// Prepare and execute the statement
$stmt = $db->prepare($sql);
$stmt->execute($params);

// Fetch the results
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the count of records
$count = $stmt->rowCount();

// Output the results
echo "<h3>Total records found: $count</h3>";
echo "<pre>";
print_r($users);
echo "</pre>";
?>

<button class="back-btn" onclick="goBack()">Go Back</button>

<script>
function goBack() {
    window.history.back();
}
</script>

</body>
</html>
