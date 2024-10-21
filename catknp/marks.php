<?php
include 'dbconnection.php'; // Include your database connection file

// Get ID from the URL parameter
$id = $_GET['id'];

// Fetch data for the specific ID
$sql = "SELECT ADNO, img FROM recieved WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$adno = $row['ADNO'];
$img = $row['img'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image & Fill Marks Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.css">
    <style>
        /* Styles for HTML elements */
        body {
            padding: 15px;
            background: rgba(117, 156, 153, 0.46);
            font-family: "Open Sans", sans-serif;
        }

        .textbox-container {
            position: absolute;
            width: 80%;
            display: flex;
        }
        
        p{
            max-width: 800px;
        }

        .textbox {
            position: relative;
            border: .05px solid #ccc;
            background-color: rgba(200, 206, 206, 0.18);
            color: black;
            padding: 4px;
            border-radius: 5px;
            z-index: 1;
            width: 93%;
            font-size: calc(6px + .7vw);
            margin-top: 30px;
        }

        .delete-button {
            position: relative;
            right: 10%;
            background-color: #ff0000;
            color: #fff;
            padding: 3px;
            border: none;
            border-radius: 5px;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            cursor: pointer;
            font-weight: 700;
            border: .2px solid #ff0000;
            z-index: 3;
        }

        .delete-button:hover {
            color: #ff0000;
            background: none;
            transition: .4s;
        }

        .image-container {
            border-radius: 25px;
            padding: 10px;
            display: flex;
            justify-content: center;
            width: 50%; /* Adjust width as needed */
            height: 900px;
            margin: 0 auto; /* Center the container */
        }

        .image-container canvas {
            border-radius: 25px;
        }

        .btns {
            font-weight: 400;
            padding: 10px 25px;
            border: 1.5px solid rgba(18, 106, 34, 0.95);
            font-size: 14px;
            border-radius: 6px;
            background-color: rgba(18, 106, 34, 0.95);
            color: white;
        }

        #btns {
            margin: 5px 0;
            padding: 5px 10px;
            font-size: 12px;
        }

        .btns:hover {
            background: none;
            color: rgba(18, 106, 34, 0.95);
            transition: .5s;
        }

        .heading {
            display: flex;
            justify-content: center;
        }

        h2 {
            color: rgba(22, 24, 24, 0.61);
            font-weight: 700;
            margin-left: 15px;
            font-size: calc(15px + 1.5vw);
            letter-spacing: 1.4;
        }

        h2::after {
            content: "";
            display: block;
            width: 10vw;
            height: .4vw;
            margin-top: 1vw;
            background-color: rgb(21, 88, 35);
            animation: lineAnimation 3s infinite;
        }

        @keyframes lineAnimation {
            0%, 100% {
                width: 10vw;
            }

            50% {
                width: 4vw;
            }
        }

        form label {
            font-weight: 500;
        }

        form input {
            padding: 13px;
            font-size: 14px;
            font-weight: 500;
            background: rgba(159, 228, 224, 0.41);
        }

        form input:focus {
            border-color: rgba(18, 106, 34, 0.95);
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        form {
            margin: 20px 0;
        }

        .toolbox,
        form,
        button {
            margin-left: 100px;
        }

        @media(max-width:600px) {
            .toolbox,
            form,
            button {
                margin-left: 0;
            }

            .image-container {
                width: 95%;
            }
        }
        
     
    </style>
</head>
<body>
    <div class="heading">
        <h2>Fill Marks for ADNO: <?php echo $adno; ?></h2>
    </div>

    <div class="image-container">
        <canvas id="canvas"></canvas>
    </div>

<style>
        #message-box {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: lightblue;
            border-bottom: 1px solid blue;
            text-align: center;
            display: none;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get references to the buttons and the text input
            var addButton = document.getElementById("add-textbox");
            var saveButton = document.getElementById("save-image");
            var submitButton = document.getElementById("btns");
            var marksInput = document.querySelector("input[name='marks']");
            var messageBox = document.getElementById("message-box");

            // Initially disable the save and submit buttons
            saveButton.disabled = true;
            submitButton.disabled = true;

            // Function to show messages
            function showMessage(message) {
                messageBox.textContent = message;
                messageBox.style.display = "block";
                setTimeout(function() {
                    messageBox.style.display = "none";
                }, 10000); // Hide after 10 seconds
            }

            // Function to show not free message
            function showNotFreeMessage() {
                showMessage("The  (Save image) and( Submit) btn are activated by (Add text box) btn. ");
            }

            // Add event listener to the Add Text Box button
            addButton.addEventListener("click", function() {
                // Enable the save button
                saveButton.disabled = false;
                showMessage("Save image button is now free!");
            });

            // Add event listener to the Save Image button
            saveButton.addEventListener("click", function() {
                // Enable the marks input field
                marksInput.removeAttribute("disabled");
                showMessage("You can now submit marks!");
            });

            // Add event listener to the marks input field
            marksInput.addEventListener("input", function() {
                // Check if marks input field is not empty
                if (marksInput.value.trim() !== "") {
                    // Enable the submit button
                    submitButton.disabled = false;
                    showMessage("BYE!");
                } else {
                    // Disable the submit button if marks input field is empty
                    submitButton.disabled = true;
                }
            });

            // Show not free messages initially
            showNotFreeMessage(); // Add Text Box button
            showNotFreeMessage(); // Save Image button
            showNotFreeMessage(); // Submit Marks button
        });
    </script>
</head>
<body>
    <!-- Message box to show button status -->
    <div id="message-box"></div>

    <div id="toolbox">
        <button class="btns" id="add-textbox">Add Text Box</button>
        <button class="btns" id="save-image" disabled>Save Image</button> <!-- Initially disabled -->
    </div>

    <form action="submit_marks.php" method="post">
        <label for="marks">Enter Marks:</label>
        <input type="text" name="marks" required disabled> <!-- Initially disabled -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button class="btns" id="btns" type="submit" disabled>Submit Marks</button> <!-- Initially disabled -->
    </form>
    
    <p id='testp'></p>
    
  


    
 


    <div id="messageBox"><?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : ''; ?></div>

    <button class="btns" id="goBackButton">Go Back</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script>
        $(document).ready(function() {
            var canvas = new fabric.Canvas('canvas', {
                preserveObjectStacking: true,
                backgroundColor: '#fff',
                selection: true,
                width: $(".image-container").width(),
                height: $(".image-container").height()
            });
            
            
        // Assuming $img contains the base64 encoded image data fetched from the database
        fabric.Image.fromURL('uploads/<?php echo $img; ?>?v=<?php echo time(); ?>',function(img) {
            img.set({
                scaleX: canvas.width / img.width,
                scaleY: canvas.height / img.height
            });
            canvas.add(img);
            canvas.renderAll();
        });


            $("#add-textbox").click(function() {
                var textBox = new fabric.Textbox('Add text here', {
                    left: 50,
                    top: 50,
                    width: 200,
                    fontSize: 20,
                    fill: '#000',
                    fontFamily: 'Arial',
                    hasControls: true,
                    hasBorders: true
                });
                canvas.add(textBox);
                canvas.setActiveObject(textBox);
                textBox.enterEditing();
                textBox.hiddenTextarea.focus();
            });
            
          $(document).ready(function() {
                $("#save-image").click(function() {
                    var imageData = canvas.toDataURL({ format: 'png', quality: 0.8 });
                    var adno = "<?php echo $adno; ?>";
            var id ="<?php echo $id; ?>";
                    $.ajax({
                        type: "POST",
                        url: "test_save.php", // This should be the path to your server-side script
                        data: { 
                            imageData: imageData,
                            adno: adno,
                            id: id
                        },
                        success: function(response) {
                            response = JSON.parse(response);
                            if(response.success){
                                alert("Image saved successfully");
                            } else{
                                alert("Image saving: " + response.message);
                            }
                            
                        },
                        error: function(xhr, status, error) {
                           
                        }
                    });
                });
            });

            $("#goBackButton").click(function() {
                window.history.back();
            });

            $("#marksForm").submit(function(e) {
                e.preventDefault();
                var marks = $("input[name='marks']").val();
                var id = $("input[name='id']").val();
                // Send marks to server via AJAX
                $.ajax({
                    url: "submit_marks.php",
                    method: "POST",
                    data: { marks: marks, id: id },
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    
    
    
    
    
</body>
</html>
