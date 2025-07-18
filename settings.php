<?php
// Database connection
require_once 'includes/db.con.php';
include 'includes/functions.php';
//include ('server.php');

if (!isset($_SESSION['username'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}

if (isset($_GET['logout'])) {
	session_start();
	$_SESSION =[];
  session_destroy();
  setcookie(session_name(), '', time() -3600, '/'); //Expire the session cookie
  unset($_SESSION['username']);
  header("location: login.php");
  exit();
}

  $errors = array(); 
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION['username'])) {
  session_destroy();
  unset($_SESSION['username']);
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<title>Connect | Affiliate Marketing</title>
<meta name="description" content="Best Affiliate Marketing, Best Work From Home, Passive Income, Top, Source Of Income">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/pagination.css">
<link rel="stylesheet" href="css/mycss.css">
<link rel="stylesheet" href="css/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="js/new_myjs.js" defer></script>
</head>
<body class="w3-theme-l5">
    
    <!-- Navigation Bar -->
	<?php if(isset($_SESSION['username'])) : ?>
		<?php include_once "includes/nav.php"; ?>
	<?php else : ?>
		<?php include_once "includes/pubnav.php"; ?>
	<?php endif ?>

<?php
		 
	if (isset($_GET['selcat'])) {
		$clickedlcat = mysqli_real_escape_string($DBconn, $_GET['selcat']);
 
		$sql = "SELECT * FROM sales WHERE category_name='$clickedlcat' OR stock_location='$clickedlcat'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
				}
			}
	}

		global $clickedlcat;

?>

<!-- Page Container -->
<div class="w3-display-container w3-content" style="max-width:1600px; margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">

    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-display-container" style="padding:10px 10px">
	<p><h2 class="w3-center">Account Settings</h2></p>
         <hr class="" style="border: 1px solid">
		 
		 <div class="w3-row">
		 <div class="w3-col m2">
		<fieldset>
		<h2 class="w3-center"><u><b>MENU</b></u></h2>
			<label title="Profile Details" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='settings.php?clickedset=profile'">
			<i class="fa fa-user"></i> Profile Details
			</label><br>
			<label title="Bank Account Details" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='settings.php?clickedset=bank'">
			<i class="fa fa-school"></i> Bank Account Details
			</label><br>
			<label title="Store Details" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='settings.php?clickedset=store'">
			<i class="fa fa-store"></i> Store Details
			</label><br>
			<label title="Privacy Settings" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='settings.php?clickedset=privacy'">
			<i class="fa fa-eye-slash"></i> Privacy Settings
			</label><br>
			<label title="Security Settings" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='settings.php?clickedset=security'">
			<i class="fa fa-lock"></i> Security Settings
			</label><br>
			<label title="Delete Account" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='settings.php?clickedset=delete'">
			<i class="fa fa-recycle"></i> Delete Account
			</label><br><br>
		</fieldset>
		 </div>
		 
		 <div class="w3-col m10">
<div class="w3-display-container">
    <div class="w3-row-padding w3-margin-top">

<style>
    .post-images {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .parent-image {
        width: 80%; /* Parent image is larger */
        margin-bottom: 20px;
    }
    .child-images {
        display: flex;
        justify-content: center;
    }
    .child-images img {
        margin: 5px;
        border: 1px solid #ddd;
        cursor: pointer;
    }
    .child-images img:hover {
        border-color: #555;
    }
</style>

<?php
		 
	if (isset($_GET['clickedset'])) {
		$clickedlset = mysqli_real_escape_string($DBconn, $_GET['clickedset']);
		$pd = "profile";
		$bd = "bank";
		$sd = "store";
		$ps = "privacy";
		$ss = "security";
		$da = "delete";
		$lu = $_SESSION['username'];

		global $clickedlset;
		global $pd;
		global $bd;
		global $sd;
		global $ps;
		global $ss;
		global $da;
		
		if ($clickedlset == $pd) {

		$sql = "SELECT * FROM connect_users WHERE uname='$lu'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) { ?>
					
                    <div class="product">
					<h2 class="w3-center"><u><b>PROFILE DETAILS</b></u></h2>
                    <!-- Display Product Images -->
                    <div class="w3-third" style="padding:10px 10px">
                        <?php
							echo "<div class='post-images'>";
                            
                            // Display the first image as the parent image
                            echo "<div class='parent-image'>";
                            echo "<img class='w3-round-large' id='parentImage' src='" . htmlspecialchars($row['user_pp']) . "' alt='Profile Picture' style='width:250px; height:250px;'>";
                            echo "</div>";

                            echo "</div>";
					?>
					</div>
					
                        <!-- Product Details -->
                        <div class="" style="padding:10px 10px">
                        <h5 class=""><b>Username:</b> <?php echo htmlspecialchars(strtoupper($row['uname'])); ?></h5>
                        <p class=""><b>Full Name:</b> <?php echo htmlspecialchars($row['lname']); ?> <?php echo htmlspecialchars($row['fname']); ?> <?php echo htmlspecialchars($row['mname']); ?></p>
                        <p class=""><b>Gender / D.O.B:</b> <?php echo $row['user_gender']; ?> | <?php echo htmlspecialchars($row['user_dob']); ?></p>
                        <p class=""><b>Phone Number:</b> <?php echo htmlspecialchars($row['pnumber']); ?></p>
                        <p class=""><b>Email Address:</b> <?php echo htmlspecialchars($row['email']); ?></p>
                        <p class=""><b>Address:</b> <?php echo htmlspecialchars($row['address']); ?></p>
					</div>
					<?php
				}
			}
		}elseif ($clickedlset == $bd) {

		$sql = "SELECT * FROM bankdetails WHERE uname='$lu'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) { ?>
					
                    <div class="product">
					<h2 class="w3-center"><u><b>BANK ACCOUNT DETAILS</b></u></h2>
                    <!-- Display Product Images -->
                    <div class="w3-third w3-hide" style="padding:10px 10px">
                        <?php
							echo "<div class='post-images'>";
                            
                            // Display the first image as the parent image
                            echo "<div class='parent-image'>";
                            echo "<img class='w3-round-large' id='parentImage' src='images/cash-time.png' alt='Profile Picture' style='width:250px; height:250px;'>";
                            echo "</div>";

                            echo "</div>";
					?>
					</div>
					
                        <!-- Product Details -->
                        <div class="" style="padding:10px 10px">
                        <p class=""><b>Bank Name:</b> <?php echo htmlspecialchars(strtoupper($row['userbankname'])); ?></p>
                        <p class=""><b>Account Name:</b> <?php echo htmlspecialchars($row['useracctname']); ?></p>
                        <p class=""><b>Account Number:</b> <?php echo $row['useracctnumber']; ?></p>
                        <p class=""><b>BVN:</b> <?php echo htmlspecialchars($row['useracctbvn']); ?></p>
					</div>
					<?php
				}
			}
		}elseif ($clickedlset == $sd) {

		$sql = "SELECT * FROM store WHERE creator_un='$lu'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) { ?>
					
                    <div class="product">
					<h2 class="w3-center"><u><b>STORE DETAILS</b></u></h2>
                    <!-- Display Product Images -->
                    <div class="w3-third" style="padding:10px 10px">
                        <?php
							echo "<div class='post-images'>";
                            
                            // Display the first image as the parent image
                            echo "<div class='parent-image'>";
                            echo "<img class='w3-round-large' id='parentImage' src='uploads/store/logos/" . htmlspecialchars($row['store_logo']) . "' alt='Profile Picture' style='width:250px; height:250px;'>";
                            echo "</div>";

                            echo "</div>";
					?>
					</div>
					
                        <!-- Product Details -->
                        <div class="" style="padding:10px 10px">
                        <p class=""><b>Store Name:</b> <?php echo htmlspecialchars(strtoupper($row['store_name'])); ?></p>
                        <p class=""><b>Store Call/WhatsApp Number:</b>
			<a href="tel:<?php echo htmlspecialchars($row['store_number']); ?>" style="text-decoration:none">
				<i class="fa fa-mobile" style="padding-right: 5px;"></i> <?php echo htmlspecialchars($row['store_number']); ?>
			</a> | 
			<a href="https://wa.me/<?php echo htmlspecialchars($row['store_whatsapp']); ?>?text=<?php echo urlencode(
				'Hello, ' . htmlspecialchars($row['store_name'])
			); ?>" 
			   target="_blank" 
			   class="whatsapp w3-text-black" style="text-decoration:none">
				<i class="fa fa-whatsapp" style="padding-right: 5px;"></i> <?php echo htmlspecialchars($row['store_whatsapp']); ?>
			</a></p>
                        <p class=""><b>Store Location:</b> <?php echo $row['store_location']; ?>, <?php echo htmlspecialchars($row['store_state']); ?></p>
                        <p class="w3-text-black"><b>Store Social Handles:</b> 
			<a href="https://facebook.com/<?php echo htmlspecialchars($row['store_fb']); ?>" target="_blank" class="facebook w3-text-black" style="text-decoration:none">
				<i class="fa fa-facebook" style="padding-right: 5px;"></i> <?php echo htmlspecialchars($row['store_fb']); ?></a> | 
            <a href="https://instagram.com/<?php echo htmlspecialchars($row['store_ig']); ?>" target="_blank" class="instagram w3-text-black" style="text-decoration:none">
				<i class="fa fa-instagram" style="padding-right: 5px;"></i> <?php echo htmlspecialchars($row['store_ig']); ?></a> | 
            <a href="https://snapchat.com/<?php echo htmlspecialchars($row['store_sc']); ?>" target="_blank" class="snapchat w3-text-black" style="text-decoration:none">
				<i class="fa fa-snapchat" style="padding-right: 5px;"></i> <?php echo htmlspecialchars($row['store_sc']); ?></a> | 
            <a href="https://tiktok.com/<?php echo htmlspecialchars($row['store_tk']); ?>" target="_blank" class="tiktok w3-text-black" style="text-decoration:none">
				<i class="fa fa-tiktok" style="padding-right: 5px;"></i> <?php echo htmlspecialchars($row['store_tk']); ?></a> | 
            <a href="https://youtube.com/<?php echo htmlspecialchars($row['store_yt']); ?>" target="_blank" class="youtube w3-text-black" style="text-decoration:none">
				<i class="fa fa-youtube" style="padding-right: 5px;"></i> <?php echo htmlspecialchars($row['store_yt']); ?></a> </p>
                        <p class=""><b>Store Description:</b> <?php echo htmlspecialchars($row['store_desc']); ?></p>
					</div>
					<?php
				}
			}
		}elseif ($clickedlset == $ps) {

		$sql = "SELECT * FROM connect_users WHERE uname='$lu'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) { ?>
					
                    <div class="product">
					<h2 class="w3-center"><u><b>PRIVACY SETTINGS</b></u></h2>
                    <!-- Display Product Images -->
                    <div class="" style="padding:10px 10px">
					<?php
				echo '<form method="POST" action="">';
				echo '		<label for="fr">Enable Friend Request?</label><br>';
				echo '		<input onclick="document.getElementById(\'frdiv\').style.display=\'none\'" type="radio" id="yes-fr" name="friend_request" value="Yes">';
				echo '		<label onclick="document.getElementById(\'frdiv\').style.display=\'none\'" for="yes-fr">Yes</label>';
				echo '		<input onclick="document.getElementById(\'frdiv\').style.display=\'block\'" type="radio" id="no-fr" name="friend_request" value="No">';
				echo '		<label onclick="document.getElementById(\'frdiv\').style.display=\'block\'" for="no-fr">No</label><br>';
						
				echo '		<div id="frdiv" style="display:none"><p>Users won\'t be able to send you friend requests.</p></div>';

				echo '		<label for="cd">Display Contact Details?</label><br>';
				echo '		<input onclick="document.getElementById(\'cddiv\').style.display=\'none\'" type="radio" id="yes-cd" name="contact_details" value="Yes">';
				echo '		<label onclick="document.getElementById(\'cddiv\').style.display=\'none\'" for="yes-cd">Yes</label>';
				echo '		<input onclick="document.getElementById(\'cddiv\').style.display=\'block\'" type="radio" id="no-cd" name="contact_details" value="No">';
				echo '		<label onclick="document.getElementById(\'cddiv\').style.display=\'block\'" for="no-cd">No</label><br>';
						
				echo '		<div id="cddiv" style="display:none"><p>Users won\'t be able to see your contact details.</p></div><br>';

				echo '		<button class="w3-green w3-round-large w3-button" type="submit" name="psets" id="psets">Submit</button>';
				echo '	</form>';
	
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['psets'])) {
	$cu = $_SESSION['username'];
	$hl = "settings.php?clickedset=privacy";
    $fr = mysqli_real_escape_string($DBconn, $_POST['friend_request']);
    $cd = mysqli_real_escape_string($DBconn, $_POST['contact_details']);
	
	$psquery = "UPDATE `connect_users` SET enable_fr ='$fr', display_cd ='$cd' WHERE uname = '$cu'";
                mysqli_query($DBconn, $psquery);
                // $_SESSION['successInfo'] = "Status updated!!!";
				//header("Location: $hl");
}
?>
					</div>
					</div>
					
					<?php
				}
			}
			
		}elseif ($clickedlset == $ss) {

		$sql = "SELECT * FROM connect_users WHERE uname='$lu'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) { ?>
					
                    <div class="product">
					<h2 class="w3-center"><u><b>SECURITY SETTINGS</b></u></h2>
                    <!-- Display Product Images -->
                    <div class="" style="padding:10px 10px">
					<?php
					echo '<form method="POST" action="">';
					echo '	<label for="fa">Enable 2FA?</label><br>';
					echo '	<input onclick="document.getElementById(\'fadiv\').style.display=\'block\'" type="radio" id="yes-fa" name="2FA" value="Yes">';
					echo '	<label onclick="document.getElementById(\'fadiv\').style.display=\'block\'" for="yes-fa">Yes</label>';
					echo '	<input onclick="document.getElementById(\'fadiv\').style.display=\'none\'" type="radio" id="no-fa" name="2FA" value="No">';
					echo '	<label onclick="document.getElementById(\'fadiv\').style.display=\'none\'" for="no-fa">No</label><br>';
						
					echo '	<div id="fadiv" style="display:none"><br>';
					echo '	<fieldset>';
					echo '	<label for="fat">You\'ll receive a six digit authentication code every time you try to login to your account.</label><br><br>';
					echo '	<label for="fat">Select Desired 2FA Type?</label><br>';
					echo '	<input type="radio" id="fasms" name="fat" value="SMS">';
					echo '	<label for="fasms">SMS</label>';
					echo '	<input type="radio" id="fawa" name="fat" value="WhatsApp">';
					echo '	<label for="fawa">WhatsApp</label>';
					echo '	<input type="radio" id="faemail" name="fat" value="Email">';
					echo '	<label for="faemail">Email</label><br>';
					echo '	</fieldset>';
					echo '  </div><br>';

					echo '	<button class="w3-green w3-round-large w3-button" type="submit" name="ssets" id="ssets">Submit</button>';
					echo '</form>';
	
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ssets'])) {
	$cu = $_SESSION['username'];
	$hls = "settings.php?clickedset=security";
    $fa = mysqli_real_escape_string($DBconn, $_POST['2FA']);
	
	if ($fa == 'Yes') {
    $fat = mysqli_real_escape_string($DBconn, $_POST['fat']);
	
	$psquery = "UPDATE `connect_users` SET 2fa ='$fa', 2fa_type ='$fat' WHERE uname = '$cu'";
                mysqli_query($DBconn, $psquery);
	}else {
	$psquery = "UPDATE `connect_users` SET 2fa ='$fa', 2fa_type ='' WHERE uname = '$cu'";
                mysqli_query($DBconn, $psquery);
	}
}
?>
					</div>
					</div>
					
					<?php
				}
			}
			
		}elseif ($clickedlset == $da) { ?>
					
                    <div class="product">
					<h2 class="w3-center"><u><b>DELETE ACCOUNT</b></u></h2>
                    <!-- Display Product Images -->
                    <div class="" style="padding:10px 10px">
					<p><strong>Please confirm you want to proceed with this action.<br>
					Once deleted, your account cannot be recovered.</strong></p>
					<p>The following actions will be performed:
					<ul>
					<li>Your primary user account would be deleted.</li>
					<li>Any associated store linked to your username would be deleted.</li>
					<li>All uploaded products/items and wishlists associated with your store account would be deleted.</li>
					<li>All posts and comments made on the social platform would be deleted.</li>
					<li>All product comments and ratings would be deleted.</li>
					<li>All chat history would be deleted.</li>
					<li>Your package subscription (if any) would be deleted and all earnings and withdrawal records would be lost.</li>
					<li>All documents used in the verification of your account during registration would be deleted.</li>
					</ul>
					</p>
					
					<form method="POST" action="">
					<button class="w3-red w3-round-large w3-button" type="submit" name="delact" id="delact"><i class="fa fa-recycle"></i> Delete Account</button>
					</form>
					</div>
					</div>
					
					<?php
	
				if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delact'])) {
					$delu = $_SESSION['username'];
                    $delactSql = "DELETE FROM connect_users WHERE uname = ?";
                    $stmt = mysqli_prepare($DBconn, $delactSql);
                    mysqli_stmt_bind_param($stmt, 's', $delu);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
				}
		}
	}
?>
	
    </div><br>
	<hr style="border: 1px solid">
	
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