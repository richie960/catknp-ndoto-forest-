<?php
include "dbconnection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $pdfName = $_POST['pdfName'];

    // Check if the PDF name already exists
    try {
        $query = "SELECT * FROM cat WHERE pdfname = :pdfName";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':pdfName', $pdfName);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: index.html?status=error");
            exit();
        }

        // File upload handling
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES['pdfFile']['name']);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFile)) {
            header("Location: formupload.php?status=error");
            exit();
        }

        // Allow only PDF files
        if ($fileType != "pdf") {
            header("Location: formupload.php?status=error");
            exit();
        }

        // Read the file content
        $pdfContent = file_get_contents($_FILES['pdfFile']['tmp_name']);

        // Insert record into the database
        $insertQuery = "INSERT INTO cat (pdfname, pdf) VALUES (:pdfName, :pdfContent)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bindParam(':pdfName', $pdfName);
        $stmt->bindParam(':pdfContent', $pdfContent, PDO::PARAM_LOB);
        $stmt->execute();

        // Notify students - Replace this with your actual notification logic

        // Redirect with success status
        header("Location: formupload.php?status=success");
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
