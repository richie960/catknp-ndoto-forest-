<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="assets/css/admin.css">

	<title>SDBMS - Admin Panel</title>
</head>
<body>
    
    
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

	 <?php
// Assuming you have a file named dbconnection.php with your database connection logic
//include 'dbconnection.php';

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

<style>
.eos-icons--hourglass {
  display: inline-block;
  width: 1em; /* Adjust the size as needed */
  height: 1em; /* Adjust the size as needed */
  --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cg%3E%3Cpath fill='%23000' d='M7 3H17V7.2L12 12L7 7.2V3Z'%3E%3Canimate id='eosIconsHourglass0' fill='freeze' attributeName='opacity' begin='0;eosIconsHourglass1.end' dur='2s' from='1' to='0'/%3E%3C/path%3E%3Cpath fill='%23000' d='M17 21H7V16.8L12 12L17 16.8V21Z'%3E%3Canimate fill='freeze' attributeName='opacity' begin='0;eosIconsHourglass1.end' dur='2s' from='0' to='1'/%3E%3C/path%3E%3Cpath fill='%23000' d='M6 2V8H6.01L6 8.01L10 12L6 16L6.01 16.01H6V22H18V16.01H17.99L18 16L14 12L18 8.01L17.99 8H18V2H6ZM16 16.5V20H8V16.5L12 12.5L16 16.5ZM12 11.5L8 7.5V4H16V7.5L12 11.5Z'/%3E%3CanimateTransform id='eosIconsHourglass1' attributeName='transform' attributeType='XML' begin='eosIconsHourglass0.end' dur='0.5s' from='0 12 12' to='180 12 12' type='rotate'/%3E%3C/g%3E%3C/svg%3E");
  background-color: currentColor;
  -webkit-mask-image: var(--svg);
  mask-image: var(--svg);
  -webkit-mask-repeat: no-repeat;
  mask-repeat: no-repeat;
  -webkit-mask-size: 100% 100%;
  mask-size: 100% 100%;
  
  /* Adjust the margin as needed */
  
  /* margin-right: 10px; /* Uncomment to move to the left by 10px */
}


.formkit--fileimage {
  display: inline-block;
  width: 1em;
  height: 1em;
  --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 15 16'%3E%3Cpath fill='%23000' d='m6.22 8.14l-3.17 4.28c-.18.24 0 .58.29.58h6.32c.3 0 .47-.34.29-.58L6.8 8.14c-.14-.2-.44-.2-.58 0'/%3E%3Cpath fill='%23000' d='m9.72 10.09l-1.9 2.57c-.11.14 0 .35.17.35h3.79c.18 0 .28-.2.17-.35l-1.89-2.57a.215.215 0 0 0-.35 0Z'/%3E%3Ccircle cx='10' cy='8' r='1' fill='%23000'/%3E%3Cpath fill='%23000' d='M12.5 16h-10c-.83 0-1.5-.67-1.5-1.5v-13C1 .67 1.67 0 2.5 0h7.09c.4 0 .78.16 1.06.44l2.91 2.91c.28.28.44.66.44 1.06V14.5c0 .83-.67 1.5-1.5 1.5M2.5 1c-.28 0-.5.22-.5.5v13c0 .28.22.5.5.5h10c.28 0 .5-.22.5-.5V4.41a.47.47 0 0 0-.15-.35L9.94 1.15A.5.5 0 0 0 9.59 1z'/%3E%3Cpath fill='%23000' d='M13.38 5h-2.91C9.66 5 9 4.34 9 3.53V.62c0-.28.22-.5.5-.5s.5.22.5.5v2.91c0 .26.21.47.47.47h2.91c.28 0 .5.22.5.5s-.22.5-.5.5'/%3E%3C/svg%3E");
  background-color: currentColor;
  -webkit-mask-image: var(--svg);
  mask-image: var(--svg);
  -webkit-mask-repeat: no-repeat;
  mask-repeat: no-repeat;
  -webkit-mask-size: 100% 100%;
  mask-size: 100% 100%;
  
}
.formkit--play {
  display: inline-block;
  width: 1em;
  height: 1em;
  --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 11 16'%3E%3Cpath fill='%23000' d='M2.5 13.62c-.24 0-.47-.06-.69-.17c-.5-.26-.81-.77-.81-1.33V3.98c0-.56.31-1.07.81-1.33s1.1-.22 1.56.11l5.77 4.07c.4.28.63.74.63 1.23s-.24.94-.63 1.23l-5.77 4.06c-.26.18-.56.28-.86.28Zm0-10.14c-.08 0-.16.02-.23.06c-.17.09-.27.25-.27.44v8.14c0 .19.1.36.27.44c.17.09.36.07.52-.04l5.77-4.07a.507.507 0 0 0 0-.82L2.79 3.57a.5.5 0 0 0-.29-.09'/%3E%3C/svg%3E");
  background-color: currentColor;
  -webkit-mask-image: var(--svg);
  mask-image: var(--svg);
  -webkit-mask-repeat: no-repeat;
  mask-repeat: no-repeat;
  -webkit-mask-size: 100% 100%;
  mask-size: 100% 100%;
 
}
.formkit--filevideo {
  display: inline-block;
  width: 0.94em;
  height: 1em;
  --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 15 16'%3E%3Cpath fill='%23000' d='m5.65 11.94l4.14-2.56c.28-.17.28-.59 0-.76L5.65 6.06c-.29-.18-.65.04-.65.38v5.11c0 .34.36.56.65.38Z'/%3E%3Cpath fill='%23000' d='M12.5 16h-10c-.83 0-1.5-.67-1.5-1.5v-13C1 .67 1.67 0 2.5 0h7.09c.4 0 .78.16 1.06.44l2.91 2.91c.28.28.44.66.44 1.06V14.5c0 .83-.67 1.5-1.5 1.5M2.5 1c-.28 0-.5.22-.5.5v13c0 .28.22.5.5.5h10c.28 0 .5-.22.5-.5V4.41a.47.47 0 0 0-.15-.35L9.94 1.15A.5.5 0 0 0 9.59 1z'/%3E%3Cpath fill='%23000' d='M13.38 5h-2.91C9.66 5 9 4.34 9 3.53V.62c0-.28.22-.5.5-.5s.5.22.5.5v2.91c0 .26.21.47.47.47h2.91c.28 0 .5.22.5.5s-.22.5-.5.5'/%3E%3C/svg%3E");
  background-color: currentColor;
  -webkit-mask-image: var(--svg);
  mask-image: var(--svg);
  -webkit-mask-repeat: no-repeat;
  mask-repeat: no-repeat;
  -webkit-mask-size: 100% 100%;
  mask-size: 100% 100%;
}
.formkit--share {
  display: inline-block;
  width: 0.94em;
  height: 1em;
  --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 15 16'%3E%3Cpath fill='%23000' d='M7.5 10c-.28 0-.5-.22-.5-.5v-8c0-.28.22-.5.5-.5s.5.22.5.5v8c0 .28-.22.5-.5.5'/%3E%3Cpath fill='%23000' d='M9.5 4a.47.47 0 0 1-.35-.15L7.5 2.2L5.85 3.85c-.2.2-.51.2-.71 0s-.2-.51 0-.71l2.01-1.99c.2-.2.51-.2.71 0l2 2c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Zm3 11h-10c-.83 0-1.5-.67-1.5-1.5v-7C1 5.67 1.67 5 2.5 5h2c.28 0 .5.22.5.5s-.22.5-.5.5h-2c-.28 0-.5.22-.5.5v7c0 .28.22.5.5.5h10c.28 0 .5-.22.5-.5v-7c0-.28-.22-.5-.5-.5h-2c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h2c.83 0 1.5.67 1.5 1.5v7c0 .83-.67 1.5-1.5 1.5'/%3E%3C/svg%3E");
  background-color: currentColor;
  -webkit-mask-image: var(--svg);
  mask-image: var(--svg);
  -webkit-mask-repeat: no-repeat;
  mask-repeat: no-repeat;
  -webkit-mask-size: 100% 100%;
  mask-size: 100% 100%;
}
</style>
	<!-- SIDEBAR -->
<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <img src="assets/icons/sms.png">
        <span class="text">SDBMS</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="#">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="#" id="elements-parent">
                <i class='bx bx-menu-alt-left'></i>
                <span class="text">Elements</span>
                <i id="down" class='bx bxs-chevron-down'></i>
                <i id="right" class='right bx bxs-chevron-right'></i>
            </a>
            <ul id="elements">
                <li class="sidebar-item text">
                    <a href="https://ndotoforest.org/catknp/display_images.php">
                        <i class='bx bx-download'></i>
                        <span class="text">Mark assignment</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="https://ndotoforest.org/catknp/formupload.php">
                        <i class='bx bx-cloud-upload'></i>
                        <span class="text">Upload pdf</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="https://ndotoforest.org/catknp/index.php">
                        <i class='bx formkit--share'></i>
                        <span class="text">Share uploaded pdf</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="https://ndotoforest.org/catknp/richie.php">
                        <i class='bx formkit--filevideo'></i>
                        <span class="text">Post video link</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="https://ndotoforest.org/catknp/yotube.php">
                        <i class='bx formkit--play '></i>
                        <span class="text">Posted videos</span>
                    </a>
                </li>

  <li class="sidebar-item">
                    <a href="https://ndotoforest.org/catknp/markedpics.php">
                        <i class='bx formkit--fileimage'></i>
                        <span class="text">Marked assignments</span>
                    </a>
                </li>
                
                
                
                <li class="sidebar-item">
                    <a href="https://ndotoforest.org/catknp/payment.php">
                        <i class='bx eos-icons--hourglass'></i>
                        <span class="text">Payments</span>
                    </a>
                </li>

              
       


		<li class="side-menu bottom">
			<li>
				<a href="https://ndotoforest.org/sdbms/admin_login.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</li>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			 <!--<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a> -->
			<a href="#" class="profile">
				<img id="prof" src="assets/img/admin.png">
				<ul id="profile-elements">
				    
                    <li><a href="https://ndotoforest.org/sdbms/admin_login.php" class="dropdown-item">Log Out</a></li>
				</ul>
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<!-- <a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a> -->
			</div>

			<ul class="box-info">
				<li>
					<span class="bx">
						<img src="assets/img/marks.png" alt="">
					</span>
					<span class="text"> 
						<h3><?php echo  $submissionStatus['notSubmitted']  ?></h3>
						<p>Students</p>
					</span>
				</li>
				<li>
					<span class="bx">
						<img src="assets/img/unmarked.png" alt="">
					</span>					
					<span class="text">
						<h3><?php echo '<p> ' . $submissionStatus['submitted'] . '</p>';; ?></h3>
						<p>submited</p>
					</span>
				</li>
				<li>
					<span class="bx">
						<img src="assets/img/markedd.png" alt="">
					</span>
					<span class="text">
						<h3><?php echo $countsEqual1['count_equal_1']; ?></h3>
						<p>Marked</p>
					</span>
				</li>
				<li>
					<span class="bx">
						<img src="assets/img/pie.png" alt="">
					</span>
					<span class="text">
						<h3><?php echo $countsNotEqualMarks['count_not_equal_marks']; ?></h3>
						<p>Unmarked Traffic</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
					
					
					
					
<!-- ======================PHP To Populate Table========================= -->

            <?php
//include 'dbconnection.php';
            // Sanitize and validate input
            function sanitize_input($input) {
                $input = trim($input);
                $input = stripslashes($input);
                $input = htmlspecialchars($input);
                return $input;
            }
            
            // Extract ADNO from the URL and sanitize it
            $adno = isset($_GET['adno']) ? sanitize_input($_GET['adno']) : '';
            
            echo    "<h3>Welcome ADMIN:
            			<span>$adno</span>
                    </h3>"; 
                    
                      ?>
            
		            <i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
		
    <?php
if (empty($adno)) {
    $adno = strtoupper($adno);
    
    // Query the database for the specified ADNO
    $sql = "SELECT img_name, date, ADNO, Marks, marked FROM recieved";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':adno', $adno, PDO::PARAM_STR);

    // Debug: Output the SQL query

    if ($stmt->execute()) {
        // Check if there are rows in the result set
        if ($stmt->rowCount() > 0) {
            echo " 
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Exams</th>
                        <th>Adno</th>
                        <th>Marks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>";

            // Loop through the rows to display data
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Check if marks column is equal to 1
                if($row["marked"] == 1) {
                    $status = "marked";
                } else {
                    $status = "unmarked";
                }
                echo '
                    <tr>
                        <td>
                            <p>' . $row['date'] . '</p>
                        </td>
                        <td>' . $row['img_name'] . '</td>
                        <td>' . $row['ADNO'] .  '</td>
                        <td>' . $row['Marks'] . '</td>
                        <td><span class="status completed">' . $status . '</span></td>
                    </tr>';
            }   
            echo ' 
                </tbody>
            </table>';
            
        } else {
            echo '<p>No records found for ADNO ' . $adno . '</p>';
        }
    } else {
        echo "<p>Error executing SQL query: ";
        print_r($stmt->errorInfo());
        echo "</p>";
    }
} else {
    echo '<p>ADNO parameter not provided</p>';
}

unset($db);
?>
		

        				</div>
        		
        			</div>
        		</main>
        		<!-- MAIN -->
        	</section>
        	<!-- CONTENT -->
        	
            


	<script src="admin.js"></script>
	
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var profileElements = document.getElementById("profile-elements");
            var profImage = document.getElementById("prof");
        
            profImage.addEventListener("click", function(event) {
                event.stopPropagation();
                if (profileElements.style.display === "none") {
                    profileElements.style.display = "block";
                } else {
                    profileElements.style.display = "none";
                }
            });
        
            document.addEventListener("click", function(event) {
                if (event.target !== profImage) {
                    profileElements.style.display = "none";
                }
            });
        });
    </script>

</body>
</html>