<?php
    include 'dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/display_images.css">
	<title>SDBMS - Display Images</title>

</head>
<body>
	


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
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
						<a href="#">
							<i class='bx bx-download'></i>
							<span class="text">Download Assignment</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a href="#">
							<i class='bx bx-cloud-upload' ></i>
							<span class="text">Upload Assignment</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a href="#">
							<i class='bx bxs-videos'></i>
							<span class="text">Learning Videos</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a href="#">
							<i class='bx bx-list-check'></i>
							<span class="text">MArked Assignments</span>
						</a>
					</li>
				</ul>
			</li>
		</ul>

		<ul class="side-menu bottom">
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

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
				    <li><a href="#" class="dropdown-item">My Profile</a></li>
                    <li><a href="#" class="dropdown-item">Settings</a></li>
                    <li><a href="https://ndotoforest.org/sdbms/student_login.php" class="dropdown-item">Log Out</a></li>
				</ul>
			</a>
		</nav>
		<!-- NAVBAR -->


<?php
    // Fetch distinct ADNO values for images that are not marked
    $sql = "SELECT ADNO FROM recieved WHERE marked IN (0, 1) GROUP BY ADNO";
    $result = $db->query($sql);
    
    echo '<main>
        	<div class="head-title">
			    <div class="left">
			        	<ul class="breadcrumb">
						<li>
							<a href="#">Students</a>
						</li>
						<li><i class="bx bx-chevron-right" ></i></li>
						<li>
							<a class="active" href="#">Display Images</a>
						</li>
					</ul>
				</div>
			</div>
			    
			
			';
    
    if ($result === false) {
        die("Query failed: " . $db->errorInfo()[2]);
    } if ($result->rowCount() > 0) {
        echo "<h1>List of Students</h1>";
               echo '<ul class="" id="box-info">';
        
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $adno = $row['ADNO'];
                echo '<li>
    					<span class="text">';
					
					echo'<h5>' . $adno . '</h5>';
                        echo '<a href= ".php?adnoimages_list=' . $adno . '">' . $adno . '</a>
					</span>
				</li>';
            }
        } else {
              echo '<ul class="" id="box-info">
    				<li>
    					<span class="text">';
					
					echo'<h5>No results found</h5>
					</span>
				</li>';
        } echo '
            
			</ul>
        </main>
    </section>';
    
    ?>


    <script src="admin.js"></script> 
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