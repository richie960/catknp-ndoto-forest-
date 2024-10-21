<?php
// Include the database connection file
include('dbconnection.php');

// Extract ADMNO from the URL
$adno = $_GET['adno'];

// Query to fetch data from the database for the specified ADMNO
$sql = "SELECT img_name, date, ADNO, Marks FROM recieved WHERE ADNO = :adno";
$stmt = $db->prepare($sql);
$stmt->bindParam(':adno', $adno, PDO::PARAM_INT);
$stmt->execute();

// Fetch data as associative array
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert data to JSON format and output
echo json_encode($data);
?>
