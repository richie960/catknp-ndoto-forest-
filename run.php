<?php
if (isset($_POST['runScript'])) {
    // Execute fff.php
    include('fff.php');

    // Redirect back to index.html
    header("Location: index.html");
    exit();
} else {
    // Redirect to index.html if accessed directly without the form submission
    header("Location: index.html");
    exit();
}
?>
