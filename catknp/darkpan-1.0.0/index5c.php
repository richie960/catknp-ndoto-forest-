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

<?php
// Assuming you have a file named dbconnection.php with your database connection logic
include 'dbconnection.php';

function checkSubmissionStatus($db) {
    // Assuming you have tables named 'logins' and 'recieved' with 'ADNO' column in both
    $queryLogins = "SELECT ADNO FROM logins";
    $stmtLogins = $db->prepare($queryLogins);
    $stmtLogins->execute();
    $adnoList = $stmtLogins->fetchAll(PDO::FETCH_COLUMN);

    $submittedCount = 0;
    $notSubmittedCount = 0;

    foreach ($adnoList as $adno) {
        $queryRecieved = "SELECT COUNT(*) as count FROM recieved WHERE ADNO = :adno";
        $stmtRecieved = $db->prepare($queryRecieved);
        $stmtRecieved->bindParam(':adno', $adno, PDO::PARAM_STR);
        $stmtRecieved->execute();
        $count = $stmtRecieved->fetchColumn();

        if ($count > 0) {
            $submittedCount++;
        } else {
            $notSubmittedCount++;
        }
    }

    return array('submitted' => $submittedCount, 'notSubmitted' => $notSubmittedCount);
}

// Usage example
// Assuming $db is the database connection variable from dbconnection.php
$submissionStatus = checkSubmissionStatus($db);

// HTML Output
//echo '<p>Submitted: ' . $submissionStatus['submitted'] . '</p>';
//echo '<p>Not Submitted: ' . $submissionStatus['notSubmitted'] . '</p>';
?>


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





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
    <style>
    body {
    background-color: white; /* Sets the background color of the body to black */
    color: white; /* Sets the text color to white */
    </style>
}

</head>

<body>
 <?php
// Assuming you have a file named dbconnection.php with your database connection logic
include 'dbconnection.php';

function countMarksForAll($db) {
    // Assuming you have a table named 'recieved' with columns 'ADNO' and 'marked'
    $queryEqual1 = "SELECT COUNT(*) as count_equal_1 FROM recieved WHERE marked = 1";
    $stmtEqual1 = $db->prepare($queryEqual1);
    $stmtEqual1->execute();
    $countEqual1 = $stmtEqual1->fetchColumn();

    $queryNotEqual1 = "SELECT COUNT(*) as count_not_equal_1 FROM recieved WHERE marked != 1";
    $stmtNotEqual1 = $db->prepare($queryNotEqual1);
    $stmtNotEqual1->execute();
    $countNotEqual1 = $stmtNotEqual1->fetchColumn();

    return array('count_equal_1' => $countEqual1, 'count_not_equal_1' => $countNotEqual1);
}

function countNotEqualMarksForAll($db) {
    // Assuming you have a table named 'recieved' with a column 'marked'
    $queryNotEqualMarks = "SELECT COUNT(*) as count_not_equal_marks FROM recieved WHERE marked != 1";
    $stmtNotEqualMarks = $db->prepare($queryNotEqualMarks);
    $stmtNotEqualMarks->execute();
    $countNotEqualMarks = $stmtNotEqualMarks->fetchColumn();

    return array('count_not_equal_marks' => $countNotEqualMarks);
}

// Usage example
// Assuming $db is the database connection variable from dbconnection.php
$countsEqual1 = countMarksForAll($db);
$countsNotEqualMarks = countNotEqualMarksForAll($db);

// Now you can use $countsEqual1['count_equal_1'], $countsEqual1['count_not_equal_1'],
// and $countsNotEqualMarks['count_not_equal_marks'] in your HTML or PHP code
?>



    <div class="container-fluid position-relative d-flex p-0">
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
                    <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
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
                </div>
                <div class="navbar-nav w-100">
                    <a href="#" class="nav-item nav-link active m-2"><i class="fa fa-tachometer-alt"></i>Dashboard</a>
                    <div class="nav-item dropdown mt-2 mb-2">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="https://ndotoforest.org/catknp/display_images.php" class="dropdown-item">Mark assignment</a>
                            <a href="https://ndotoforest.org/catknp/formupload.php" class="dropdown-item">Upload pdf</a>
                          <a href="https://ndotoforest.org/catknp/index.php" class="dropdown-item">Post pdf</a>
                     <a href="https://ndotoforest.org/catknp/richie.php" class="dropdown-item">Post video link</a>
                    <a href="https://ndotoforest.org/catknp/yotube.php" class="dropdown-item">Posted videos</a>
                         <a href="https://ndotoforest.org/catknp/payment.php" class="dropdown-item">Payments</a>
                          <a href="https://ndotoforest.org/catknp/markedpics.php" class="dropdown-item">Marked assignments</a>
                        
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
                            <span class="d-none d-lg-inline-flex">knp</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="https://ndotoforest.org/catknp/LOGINAD.php" class="dropdown-item">Log Out</a>
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
                                <p class="mb-2">Students</p>
                                <h6 class="mb-0">
                                    <?php echo  $submissionStatus['notSubmitted']  ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">submited</p>
                                <h6 class="mb-0"> <?php echo '<p> ' . $submissionStatus['submitted'] . '</p>';;
 ?></p></p></h6>
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
                                <p class="mb-2">Cats unmarked</p>
                                <h6 class="mb-0"><?php echo $countsNotEqualMarks['count_not_equal_marks']; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
         
            <!-- Sales Chart End -->
   <h6 class="mb-0">CAT INFO</h6>

            <!-- Recent Sales Start -->
            
 <style>
    body {
        background-color: white;
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

// Query to fetch data from the database for all ADNO
$sql = "SELECT * FROM recieved";
$stmt = $db->prepare($sql);
$stmt->execute();

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
            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
        </tr>';
    }

    echo '
            </tbody>
        </table>
    </div>
</div>';
} else {
    echo '<p>No records found.</p>';
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

<body>

</body>
</html>
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
