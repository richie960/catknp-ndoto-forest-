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
    // unset($db);
    ?>
    
   <?php 
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

?>
	


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
            <img src="assets/icons/sms.png">
			<span class="text">SDBMS</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
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
						<a href="https://ndotoforest.org/catknp/student.php">
							<i class='bx bx-download'></i>
							<span class="text">Download Assignment</span>
						</a>
					</li>
					<li class="sidebar-item">
					    	<a href="#" onclick="redirectToPage1()">
						
							<i class='bx bx-cloud-upload' ></i>
							<span class="text">Upload Assignment</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a href="https://ndotoforest.org/catknp/yotube.php">
							<i class='bx bxs-videos'></i>
							<span class="text">Learning Videos</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a href="#" onclick="redirectToPage()">
							<i class='bx bx-list-check'></i>
							<span class="text">Marked Assignments</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>

		<ul class="side-menu bottom">
			<li>
				<a href="https://ndotoforest.org/sdbms/student_login.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
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
				 <li><a href="https://ndotoforest.org/sdbms/student_login.php" class="dropdown-item">Log Out</a></li>
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
						<h3><?php echo $totalMarks ?></h3>
						<p>Latest Marks</p>
					</span>
				</li>
				<li>
					<span class="bx">
						<img src="assets/img/unmarked.png" alt="">
					</span>					
					<span class="text">
						<h3><?php echo $countsEqual1['count_not_equal_1']; ?></h3>
						<p>Unmarked</p>
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
            
            // Sanitize and validate input
            function sanitize_input($input) {
                $input = trim($input);
                $input = stripslashes($input);
                $input = htmlspecialchars($input);
                return $input;
            }
            
            // Extract ADNO from the URL and sanitize it
            $adno = isset($_GET['adno']) ? sanitize_input($_GET['adno']) : '';
            
            echo    "<h3>Welcome ADNO:
            			<span>$adno</span>
                    </h3>"; 
                    
                      ?>
            
		            <i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
		
    <?php
if (!empty($adno)) {
    $adno = strtoupper($adno);
    
    // Query the database for the specified ADNO
    $sql = "SELECT img_name, date, ADNO, Marks, marked FROM recieved WHERE UPPER(TRIM(ADNO)) = :adno";
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
           function redirectToPage1() {
            // Get the 'adno' parameter from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const adno = urlParams.get('adno');

            // Define the target URL where you want to redirect
            const targetUrl = "https://ndotoforest.org/catknp/UPLOADSTU.php"; // Change this URL as needed

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