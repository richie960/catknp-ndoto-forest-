<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance</title>
    <style>
        /* CSS for styling the under maintenance message */
        .under-maintenance {
            font-size: 24px;
            text-align: center;
            margin-top: 50px;
            color: red; /* Set text color to red */
        }
    </style>
</head>
<body>
    <div class="under-maintenance" id="maintenanceMessage"></div>

    <script>
        // JavaScript code to display under maintenance message
        window.onload = function() {
            // Get the current date and time
            var now = new Date();
            var hour = now.getHours();
            var day = now.getDay();

            // Check if it's between 8:00 PM and 6:00 AM or if it's Sunday (0)
            if ((hour >= 20 || hour < 6) || day === 0) {
                // Display under maintenance message
                document.getElementById('maintenanceMessage').innerText = 'Under Maintenance';
            }
        };
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .message-box {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            color: white;
            font-weight: bold;
            display: none;
            transition: background-color 0.5s;
            z-index: 9999; /* Set a higher z-index value */
        }

        .green {
            background-color: green;
        }

        .red {
            background-color: red;
        }
    </style>
</head>
<body>
    <div id="messageBox" class="message-box"></div>

    <script>
        // Function to parse URL parameters
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Function to display message box
        function displayMessageBox(message, isError) {
            var messageBox = document.getElementById("messageBox");
            messageBox.textContent = message;

            if (isError) {
                messageBox.classList.remove("green");
                messageBox.classList.add("red");
            } else {
                messageBox.classList.remove("red");
                messageBox.classList.add("green");
            }

            messageBox.style.display = "block";

            // Hide the message box after 3 seconds
            setTimeout(function() {
                messageBox.style.display = "none";
            }, 3000);
        }

        // Read information from the URL
        var adno = getParameterByName("adno");
        var message = getParameterByName("adno");

        // Display message box based on the information
        if (adno !== null && message !== null) {
            displayMessageBox("Message: "  message, false);
        } else {
            displayMessageBox("No information in the URL", true);
        }
    </script>
</body>
</html>
 <?php  $totalMarks=0 ?>

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
   // echo "Total marks for ADNO $adno and date $nearestDate: $totalMarks";
} else {
    // If no suitable date found for the given ADNO, output a message
   // echo "No records found for ADNO $adno";
}

// Close the database connection
unset($db);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>KHUB</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="https://ndotoforest.org/catknp/D.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
   <?php
// Assuming you have a file named dbconnection.php with your database connection logic
include 'dbconnection.php';

function countMarks($admno, $db) {
    // Assuming you have a table named 'recieved' with columns 'ADNO' and 'marked'
    $queryEqual1 = "SELECT COUNT(*) as count_equal_1 FROM recieved WHERE ADNO = :admno AND marked = 1";
    $stmtEqual1 = $db->prepare($queryEqual1);
    $stmtEqual1->bindParam(':admno', $admno, PDO::PARAM_STR);
    $stmtEqual1->execute();
    $countEqual1 = $stmtEqual1->fetchColumn();

    $queryNotEqual1 = "SELECT COUNT(*) as count_not_equal_1 FROM recieved WHERE ADNO = :admno AND marked != 1";
    $stmtNotEqual1 = $db->prepare($queryNotEqual1);
    $stmtNotEqual1->bindParam(':admno', $admno, PDO::PARAM_STR);
    $stmtNotEqual1->execute();
    $countNotEqual1 = $stmtNotEqual1->fetchColumn();

    return array('count_equal_1' => $countEqual1, 'count_not_equal_1' => $countNotEqual1);
}

function countNotEqualMarks($db) {
    // Assuming you have a table named 'recieved' with a column 'marked'
    $queryNotEqualMarks = "SELECT COUNT(*) as count_not_equal_marks FROM recieved WHERE marked != 1";
    $stmtNotEqualMarks = $db->prepare($queryNotEqualMarks);
    $stmtNotEqualMarks->execute();
    $countNotEqualMarks = $stmtNotEqualMarks->fetchColumn();

    return array('count_not_equal_marks' => $countNotEqualMarks);
}

// Usage example
$admno = $_GET['adno'];

// Assuming $db is the database connection variable from dbconnection.php
$countsEqual1 = countMarks($admno, $db);
$countsNotEqualMarks = countNotEqualMarks($db);

// Now you can use $countsEqual1['count_equal_1'], $countsEqual1['count_not_equal_1'],
// and $countsNotEqualMarks['count_not_equal_marks'] in your HTML or PHP code
?>
  <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="#" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>KHUB</h3>
                </a>
       <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="https://ndotoforest.org/catknp/D.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"></h6>
                        <span></span>
</div>
            </diV>
                
              <div class="navbar-nav w-100">
                    <a href="#" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                        <div class="dropdown-menu bg-transparent border-0">
                        
                            <a href="https://ndotoforest.org/catknp/student.php" class="dropdown-item">Download assignment</a>
                            <a href="https://ndotoforest.org/catknp/UPLOADSTU.php" class="dropdown-item">Upload assignment</a>
                     <a href="https://ndotoforest.org/catknp/yotube.php" class="dropdown-item">learning videos</a>
    
    <script>
        function redirectToPage() {
            // Get the 'adno' parameter from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const adno = urlParams.get('adno');

            // Define the target URL where you want to redirect
            const targetUrl = "https://ndotoforest.org/catknp/markedimagesforstudents.php"; // Change this URL as needed

            // Check if 'adno' is not null or undefined
            if (adno) {
                // Redirect to the new page with the 'adno' parameter
                window.location.href = `${targetUrl}?adno=${encodeURIComponent(adno)}`;
            } else {
                alert('Adno parameter is missing.');
            }
        }
    </script>
</head>
<body>
    <!-- Button that triggers the redirection when clicked -->
    <button class="link-button" onclick="redirectToPage()">  marked_assignment</button>
</body>
</html>

                        </div>
                    </div>
                
           
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="#" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                   
                    <div class="nav-item dropdown">
                        
                        
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="https://ndotoforest.org/catknp/D.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">KHUB</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="https://ndotoforest.org/catknp/login.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
 


            </nav>
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Latest marks</p>
                                <h6 class="mb-0">
                                    <?php echo $totalMarks ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Unmarked</p>
                                <h6 class="mb-0">     <p>    <p><?php echo $countsEqual1['count_not_equal_1']; ?></p></p></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Marked</p>
                                <h6 class="mb-0">  <p> <?php echo $countsEqual1['count_equal_1']; ?></p></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2"> Unmarked Traffic</p>
                                <h6 class="mb-0"><?php echo $countsNotEqualMarks['count_not_equal_marks']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sale & Revenue End -->

<!DOCTYPE html>
<html>
<head>
    <title>Reload Page Button</title>
    <style>
        /* Style for the reload button */
        #reloadButton {
            background-color: red;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <button id="reloadButton">Reload</button>

    <script>
        // Add event listener to the reload button
        document.getElementById('reloadButton').addEventListener('click', function() {
            // Reload the page when the button is clicked
            location.reload();
        });
    </script>
</body>
</html>

            <!-- Sales Chart Start -->
         
            <!-- Sales Chart End -->
   <h6 class="mb-0">CAT INFO</h6>

            <!-- Recent Sales Start -->
            
 <style>
    body {
        background-color: black;
        color: red;
    }

    h6,
    a,
    th,
    td {
        color: red;
    }

    .table {
        background-color: white;
        color: red;
    }

    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border-color: red;
    }

    .btn-primary {
        background-color: red;
        color: black;
    }

    .btn-primary:hover {
        background-color: black;
        color: red;
    }
</style>
<?php
// Include the database connection file
include('dbconnection.php');

// Function to sanitize and validate input
function sanitize_input($input) {
    // Remove whitespace from the beginning and end of the input
    $input = trim($input);
    // Remove slashes
    $input = stripslashes($input);
    // Convert special characters to HTML entities to prevent XSS attacks
    $input = htmlspecialchars($input);
    return $input;
}

// Extract ADNO from the URL and sanitize it
$adno = isset($_GET['adno']) ? sanitize_input($_GET['adno']) : '';

// Debug: Output the provided ADNO after sanitization
echo "<p>Welcome ADNO: $adno</p>";

// Check if ADNO is not empty
if (!empty($adno)) {
    // Convert ADNO to uppercase
    $adno = strtoupper($adno);

    // Debug: Output the sanitized and uppercase ADNO
   // echo "<p>Sanitized and Uppercase ADNO: $adno</p>";

    // Query to fetch data from the database for the specified ADNO (case-insensitive and ignoring leading/trailing whitespace)
    $sql = "SELECT img_name, date, ADNO, Marks FROM recieved WHERE UPPER(TRIM(ADNO)) = :adno";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':adno', $adno, PDO::PARAM_STR);

    // Debug: Output the SQL query
 //   echo "<p>SQL Query: $sql</p>";

    if ($stmt->execute()) {
        // Check if there are rows in the result set
        if ($stmt->rowCount() > 0) {
            echo '
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col"><input class="form-check-input" type="checkbox"></th>
                            <th scope="col">Date</th>
                            <th scope="col">Examinations</th>
                            <th scope="col">ADNO</th>
                            <th scope="col">Marks</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>';

            // Loop through the rows and display data
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '
                <tr>
                    <td><input class="form-check-input" type="checkbox"></td>
                    <td>' . $row['date'] . '</td>
                    <td>' . $row['img_name'] . '</td>
                    <td>' . $row['ADNO'] . '</td>
                    <td>' . $row['Marks'] . '</td>
                    <td><a class="btn btn-sm btn-primary" href="#">Detail</a></td>
                </tr>';
            }

            echo '
                    </tbody>
                </table>
            </div>
        </div>';
        } else {
            echo '<p>No records found for ADNO ' . $adno . '</p>';
        }
    } else {
        // Debug: Output any errors in executing the query
        echo "<p>Error executing SQL query: ";
        print_r($stmt->errorInfo());
        echo "</p>";
    }
} else {
    echo '<p>ADNO parameter not provided</p>';
}

// Close the database connection
unset($db);
?>

 

            <!-- Recent Sales End -->


            <!-- Widgets End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">KNP HUB</a>, All Rights Reserved
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By richard_><a href="https://wa.me/254770467092?=Hello i want a frontend and bankend job 🤑🤑.">WhatsApp Me</a>

                            <br>Distributed By: <a href="https://wa.me/254770467092?text=Hello i need developers for hire">WhatsApp Me</a>
                            <a>biz mtandaoni</a>
                            <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #largeImageContainer {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999; /* Set a high z-index to ensure it appears above other content */
        }

        #largeImage {
            max-width: 150%;
            max-height: 150%;
            border-radius: 50%; /* Make it a circle */
        }

        .closeIcon {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9998; /* Set a z-index lower than the large image container */
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background to overlay on other content */
            display: none;
        }

        .thumbnail-container {
            position: relative;
            z-index: 1; /* Set a higher z-index for the thumbnail container */
        }
    </style>
</head>
<body>

<div class="overlay" id="overlay"></div>

<div class="thumbnail-container d-flex align-items-center ms-4 mb-4">
    <div class="position-relative">
        <img class="rounded-circle" src="https://ndotoforest.org/catknp/D.png" alt="" style="width: 50px; height: 50px;"> <!-- Increase the size of the circle -->
        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1" id="openImage"></div>
    </div>
</div>

<div id="largeImageContainer">
    <span class="closeIcon" onclick="closeImage()">X</span>
    <img id="largeImage" src="" alt="">
</div>

<script>
    document.getElementById("openImage").addEventListener("click", openImage);

    function openImage() {
        var thumbnailSrc = document.querySelector(".thumbnail-container img").src;
        document.querySelector("#largeImage").src = thumbnailSrc;
        document.getElementById("largeImageContainer").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    }

    function closeImage() {
        document.getElementById("largeImageContainer").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }
</script>

</body>
</html>

                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .message-box {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            color: white;
            font-weight: bold;
            display: none;
            transition: background-color 0.5s;
        }

        .green {
            background-color: green;
        }

        .red {
            background-color: red;
        }
    </style>
</head>
<body>
    <div id="messageBox" class="message-box"></div>

    <script>
        // Function to parse URL parameters
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Function to display message box
        function displayMessageBox(message, isError) {
            var messageBox = document.getElementById("messageBox");
            messageBox.textContent = message;

            if (isError) {
                messageBox.classList.remove("green");
                messageBox.classList.add("red");
            } else {
                messageBox.classList.remove("red");
                messageBox.classList.add("green");
            }

            messageBox.style.display = "block";

            // Hide the message box after 3 seconds
            setTimeout(function() {
                messageBox.style.display = "none";
            }, 3000);
        }

        // Read information from the URL
        var adno = getParameterByName("adno");
        var message = getParameterByName("adno");

        // Display message box based on the information
        if (adno !== null && message !== null) {
            displayMessageBox("ADNO: " + adno + " - Message: " + message, false);
        } else {
            displayMessageBox("No information in the URL", true);
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Page</title>
    <script>
    // Push a new state to the browser history
    history.pushState(null, null, document.URL);

    // Listen for the back/forward button event
    window.addEventListener('popstate', function() {
        // Push another state to prevent going back
        history.pushState(null, null, document.URL);
    });
    </script>
</head>
<script>

</script>
<body>

</body>
</html
