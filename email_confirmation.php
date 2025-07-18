<?php
require_once 'includes/db.con.php';
include 'includes/functions.php';
		 
	if (isset($_GET['conemail'])) {
		$clickedemail = mysqli_real_escape_string($DBconn, $_GET['conemail']);
		$clickeduname = mysqli_real_escape_string($DBconn, $_GET['conuname']);
		
		global $clickedemail;
		global $clickeduname;
 
		$sql = "SELECT * FROM connect_users WHERE uname='$clickeduname' AND email='$clickedemail'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
					$upsql = "UPDATE connect_users SET active ='1' WHERE uname='$clickeduname' AND email='$clickedemail'";
                    mysqli_query($DBconn, $upsql);
					header("Location: email_confirmation.php");
			}
	}

		global $clickedlcat;

?>

<!DOCTYPE html>
<html lang="en">
<title>Connect | Affiliate Marketing</title>
<meta name="description" content="Best Affiliate Marketing, Best Work From Home, Passive Income, Top, Source Of Income">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/mycss.css">
<link rel="stylesheet" href="css/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
<script src="js/new_myjs.js" defer></script>
<style>

html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}

body,h1 {font-family: "Open Sans", sans-serif}
body, html {height: 100%}
.bgimg {
  background-image: url('images/forestbridge.jpg');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
</style>
<body style="text-align: center;">
<!-- Navbar -->
<?php
  include 'includes/pubnav.php';
  ?>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white w3-animate-zoom"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">

<div class="w3-container w3-card w3-round-xlarge w3-white" style="padding-left: 50px; padding-right: 50px; ">
        <div class="w3-container w3-animate-zoom w3-center w3-black w3-padding-16" style=" width:100%">
            <p><h2 class="w3-text-amber">ACCOUNT ACTIVATED</h2></p>
        </div>

        <div class="w3-container w3-animate-zoom w3-center w3-padding-64" style="width:100%">
        <p>Your E-mail address has been confirmed, and your account was successfully activated.<br><br>
            You are now an official member of the Connect Family.<br>
			

      <p class="w3-center">
        <span class="w3-padding w3-text-blue "><a href="login.php">LOGIN</a></span>
      </p><br>
            <b>important:</b> Do not provide your login and password to anyone.<br>
            <b>CONNECT</b> will, on no account, request for your login details at anytime.<br>
			Stay safe and vigilant.
        </p>
</div>
</div>
</div>
<button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-arrow-up" style="border-radius: 50%"> </button>
<!-- Footer -->
<?php
  include 'includes/footer.php';
  ?>
</body>
</html>