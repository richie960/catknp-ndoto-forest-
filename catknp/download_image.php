<?php
include 'dbconnection.php'; // Include your database connection file

// Get ID from the URL parameter
$id = $_GET['id'];

// Fetch image data for the specific ID
$sql = "SELECT img FROM recieved WHERE id = :id AND marked = 0"; // Ensure marked is 0
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);

if ($stmt->execute() === false) {
    die("Query failed: " . $stmt->errorInfo()[2]);
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Set the appropriate headers for image file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $row['img'] . '"');
readfile('uploads/' . $row['img']);

// Redirect to another page after successful download
header('Location: marks.php?id=' . $id);
exit();
?>

