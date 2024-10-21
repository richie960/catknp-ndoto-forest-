<?php
// Include the database connection file
include('dbconnection.php');

// Extract ADNO from the URL
$adno = $_GET['adno']; // You might need to adjust this based on your URL structure

// Query to find the nearest date to the current date that has records associated with the provided ADNO
$sqlNearestDate = "SELECT date FROM recieved WHERE ADNO = :adno AND date <= CURRENT_DATE() ORDER BY ABS(DATEDIFF(date, CURRENT_DATE())) ASC LIMIT 1";
$stmtNearestDate = $db->prepare($sqlNearestDate);
$stmtNearestDate->bindParam(':adno', $adno, PDO::PARAM_STR);
$stmtNearestDate->execute();
$nearestDate = $stmtNearestDate->fetchColumn();

if ($nearestDate) {
    // Fetch the marks for the nearest date and ADNO
    $sqlSumMarks = "SELECT SUM(Marks) AS total_marks FROM recieved WHERE ADNO = :adno AND date = :nearest_date";

    // Fetch the total sum of marks
    $stmtSumMarks = $db->prepare($sqlSumMarks);
    $stmtSumMarks->bindParam(':adno', $adno, PDO::PARAM_STR);
    $stmtSumMarks->bindParam(':nearest_date', $nearestDate, PDO::PARAM_STR);
    $stmtSumMarks->execute();

    $totalMarks = 0;
    $sumRow = $stmtSumMarks->fetch(PDO::FETCH_ASSOC);
    if ($sumRow && $sumRow['total_marks'] !== null) {
        $totalMarks = $sumRow['total_marks'];
    }

    // Output the result
    echo "Total marks for ADNO $adno and date $nearestDate: $totalMarks";
} else {
    // If no suitable date found for the given ADNO, output a message
    echo "No records found for ADNO $adno";
}

// Close the database connection
unset($db);
?>
