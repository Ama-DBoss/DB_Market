<?php
require_once 'includes/db.con.php'; // Include your database connection
include 'includes/functions.php';
include ('server.php');

if (isset($_GET['logout'])) {
	session_start();
	$_SESSION =[];
  session_destroy();
  setcookie(session_name(), '', time() -3600, '/'); //Expire the session cookie
  unset($_SESSION['username']);
  header("location: login.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Connect | Affiliate Marketing</title>
<meta name="description" content="Best Affiliate Marketing, Best Work From Home, Passive Income, Top, Source Of Income">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/mycss.css">
<link rel="stylesheet" href="css/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="js/new_myjs.js" defer></script>

<!-- Auto sign-outout user if inactive. -->
<script src="includes/sessionTimeout.js"></script>
</head>
<body class="w3-theme-l5">
    
<?php
    include 'includes/nav.php';
?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1600px;margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">
    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-container" style="padding:10px 10px">
    <h2 class="w3-wide w3-center">MY FILES</h2>
	<h1 class="w3-text-red">
		<?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?>
	</h1>
         <hr style="border: 1px solid">
      <!-- Accordion -->
      <div class="w3-round">
        <div class="w3-white">
          <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-camera fa-fw w3-margin-right"></i> MY PHOTOS</button>
          <div id="Demo1" class="w3-hide w3-container">
		  		<div class="w3-row-padding">
						 <?php
								  $userin = $_SESSION['username'];

				// Fetch posts
				$sql = "SELECT * FROM posts WHERE uname='$userin' AND post_img != '' ORDER BY ID DESC LIMIT 6";
				$stmt = $DBconn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows <= 0) {
					echo "You haven't uploaded any photo yet!!!";
				} elseif ($result->num_rows > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
					$postFile = $row["post_img"] ?? ''; // Default to an empty string if post_img is null
					$fileType = '';
					if (!empty($postFile)) {
						$fileType = strtolower(pathinfo($postFile, PATHINFO_EXTENSION));
					}
					
						if ($fileType && in_array($fileType, ["jpg", "jpeg", "png", "gif"])) {
							echo '
							   <div class="w3-col s3 m2 l2" style="padding-top: 10px">
								 <img src="' . htmlspecialchars($postFile) . '" style="width:100%" class="w3-margin-bottom">
							   </div>';
						}
					}
				}else{
							echo "You haven't uploaded any photo yet!!!";
						}
								?>
							 </div>

		  </div>
		  
          <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-camera fa-fw w3-margin-right"></i> MY VIDEOS</button>
          <div id="Demo2" class="w3-hide w3-container">
		  		<div class="w3-row-padding">
						 <?php
								  $userin = $_SESSION['username'];

				// Fetch posts
				$sql = "SELECT * FROM posts WHERE uname='$userin' AND post_img != '' ORDER BY ID DESC LIMIT 6";
				$stmt = $DBconn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows <= 0) {
					echo "You haven't uploaded any video yet!!!";
				} elseif ($result->num_rows > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
					$postFile = $row["post_img"] ?? ''; // Default to an empty string if post_img is null
					$fileType = '';
					if (!empty($postFile)) {
						$fileType = strtolower(pathinfo($postFile, PATHINFO_EXTENSION));
					}
					
						if ($fileType && in_array($fileType, ["mp4", "avi", "mov"])) {
							echo '
							   <div class="w3-col s3 m2 l2" style="padding-top: 10px">
							   <video controls style="width:100%" class="w3-margin-bottom">
								<source src="'.htmlspecialchars($postFile) . '" type="video/' . htmlspecialchars($fileType) . '">
											  Your browser does not support the video tag.
							   </video>
							   </div>';
						}
					}
				}else{
							echo '<br>You haven\'t uploaded any video yet!!!';
						}
								?>
							 </div>
		  </div>
		  
          <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-file fa-fw w3-margin-right"></i> MY AUDIOS</button>
          <div id="Demo3" class="w3-hide w3-container">
		  		<div class="w3-row-padding">
						 <?php
								  $userin = $_SESSION['username'];

				// Fetch posts
				$sql = "SELECT * FROM posts WHERE uname='$userin' AND post_img != '' ORDER BY ID DESC LIMIT 6";
				$stmt = $DBconn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows <= 0) {
					echo "You haven't uploaded any audio yet!!!";
				} elseif ($result->num_rows > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
					$postFile = $row["post_img"] ?? ''; // Default to an empty string if post_img is null
					$fileType = '';
					if (!empty($postFile)) {
						$fileType = strtolower(pathinfo($postFile, PATHINFO_EXTENSION));
					}
					
						if ($fileType && in_array($fileType, ["mp3", "wav"])) {
							echo '
							   <div class="w3-col s3 m2 l2" style="padding-top: 10px">
							<audio controls style="width:100%" class="w3-margin-bottom">
							<source src="' . htmlspecialchars($postFile) . '" type="audio/' . htmlspecialchars($fileType) . '">
								  Your browser does not support the audio tag.
							</audio>
							   </div>';
						}
					}
				}else{
							echo "You haven't uploaded any audio yet!!!";
						}
								?>
							 </div>
		  </div>
		  
          <button onclick="myFunction('Demo4')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-file fa-fw w3-margin-right"></i> MY DOCUMENTS</button>
          <div id="Demo4" class="w3-hide w3-container">
			<div class="w3-row-padding">
						 <?php
								  $userin = $_SESSION['username'];

				// Fetch posts
				$sql = "SELECT * FROM posts WHERE uname='$userin' AND post_img != '' ORDER BY ID DESC LIMIT 6";
				$stmt = $DBconn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows <= 0) {
					echo "You haven't uploaded any document yet!!!";
				} elseif ($result->num_rows > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
					$postFile = $row["post_img"] ?? ''; // Default to an empty string if post_img is null
					$fileType = '';
					if (!empty($postFile)) {
						$fileType = strtolower(pathinfo($postFile, PATHINFO_EXTENSION));
					}
					
						if (($fileType && in_array($fileType, ["pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "txt"]))) {
							echo '  
							   <div class="w3-col s3 m2 l2" style="padding-top: 10px">
								 <a href="' . htmlspecialchars($postFile) . '" target="_blank" class="w3-margin-bottom"><i class="fa fa-file fa-fw w3-margin-right"></i>' . htmlspecialchars(basename($postFile)) . '</a>
							   </div>';
						}
					}
				}else{
							echo "You haven't uploaded any document yet!!!";
						}
								?>
							 </div>
		  </div>

	</div>
  </div>
        </div>
    </div>
</div>
</div>
<button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-arrow-up" style="border-radius: 50%"></button>
<?php
    include 'includes/footer.php';
?>
</body>
</html>