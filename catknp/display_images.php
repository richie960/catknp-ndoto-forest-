<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Message from URL</title>
</head>
<body>
    
<style>
    body{
        margin: 0;
        padding: 0;
        background: #736d6a;
        padding: 0 calc(5px + 2vh);
    }
    .pdf-list-container {
        text-align: center;
         background-color: #494f4e;
         margin-top: 13px;
         height:100vh;
         display: flex;
         flex-direction: column;
         align-items:center;
         border-radius: 20px;
    }

    h2 {
        color: white;
        margin-top: 20px;
    }

    .pdf-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        background-color: #dce6e4;
        margin-bottom: 20px;
        width: 80vw;
    }

    .pdf-link {
        color: #007bff;
        text-decoration: none;
        display: block;
        margin-top: 10px;
    }

    .pdf-link:hover {
        text-decoration: underline;
    }
    
    #goBackButton{
          display: inline-block;
          padding: 10px 20px;
          background-color: #ffffff;
          color: #000000;
          text-decoration: none;
          border-radius: 15px;
          font-weight: bold;
          cursor: pointer;
          margin-top: 30px;
          font-weight: 600;
    }
    
    #goBackButton:hover{
        color: #dce6e4;
        background: #000;
        transition: .3s;
    }

    
    
  
</style>    
    
    

    
    
    <button id="goBackButton">Go back</button>

<script>
document.getElementById("goBackButton").addEventListener("click", function() {
  window.location.href = "https://ndotoforest.org/sdbms/admin_teach.php";
});
</script>





<?php
include 'dbconnection.php'; // Include your database connection file

// Fetch distinct ADNO values for images that are not marked
$sql = "SELECT ADNO FROM recieved WHERE marked IN (0, 1) GROUP BY ADNO";
$result = $db->query($sql);

echo "<div class='pdf-list-container'>";

if ($result === false) {
    die("Query failed: " . $db->errorInfo()[2]);
}

if ($result->rowCount() > 0) {
    echo "<h2>List of ADNO:</h2>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $adno = $row['ADNO'];

        // Display a heading for each ADNO
        echo "<div class='pdf-card'>";
        echo "<h3>ADNO: $adno</h3>";
        echo "<a class='pdf-link' href='download2.php?adno=$adno'>$adno</a>";
        echo "</div>";
    }
} else {
    echo "<p>No results found.</p>";
}

echo "</div>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Message from URL</title>
    <style>
    #messageBox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        display: none;
        transition: opacity 1s ease-in-out;
    }

    #messageBox.success {
        background-color: green;
        color: white;
    }

    #messageBox.error {
        background-color: red;
        color: white;
    }
    </style>
</head>

<body>

    <?php
// Extract the message from the URL
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Determine if the message contains the word "not"
$hasNot = stripos($message, 'not') !== false;

// Apply the class based on the presence of "not"
$class = $hasNot ? 'error' : 'success';

echo "<div id='messageBox' class='$class'>$message</div>";
?>

    <script>
    // JavaScript to display the message box
    document.addEventListener("DOMContentLoaded", function() {
        var messageBox = document.getElementById('messageBox');
        if (messageBox) {
            messageBox.style.display = 'block';
            setTimeout(function() {
                messageBox.style.opacity = 0;
            }, 10000);
        }
    });
    </script>
    
</body>
</html>
