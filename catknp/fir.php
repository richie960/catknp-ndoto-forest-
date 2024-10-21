<?php
// Specify the directory where PDF files are stored
$pdfDirectory = './';

// Get the filename from the query parameter
$filename = $_GET['filename'];

// Validate the filename to prevent directory traversal
if (strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
    die("Invalid filename");
}

// Generate the full path to the PDF file
$filePath = $pdfDirectory . '/' . $filename;

// Check if the file exists
if (file_exists($filePath)) {
    // Set the appropriate headers for PDF file
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filePath));

    // Output the PDF content
    readfile($filePath);
    exit();
} else {
    echo "PDF not found.";
}
?>
