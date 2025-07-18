<style>
  @font-face {
   font-family: myFirstFont;
   src: url(sansation_light.woff);
}

* {
   font-family: myFirstFont;
   font-size: 16px;
}
</style>
<!-- Navbar -->
<div class="w3-top w3-hide-small">
 
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-medium w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <?php if(isset($_SESSION['username'])) {
	  echo '
  <a href="mypage.php" class="w3-bar-item w3-padding-medium w3-theme-d2 w3-hover-white"><img class="w3-circle" src="images/logo.png" alt="Connect" ></a>' ;
  }else { echo '
  <a href="index.php" class="w3-bar-item w3-padding-medium w3-theme-d2 w3-hover-white"><img class="w3-circle" src="images/logo.png" alt="Connect" ></a>' ; } ?>
  <?php if(isset($_SESSION['username'])) {
	  echo "";
  }else { echo '
  <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="home"><i class="fa fa-home"> Home</i></a>' ; } ?>
  <a href="mypage.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="feed" style="cursor:pointer"><i class="fa fa-book"></i> Feeds</a>
  <a href="acc_settings.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Profile" style="cursor:pointer"><i class="fa fa-gauge-high"></i> Dashboard</a>
  <a href="package.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Packages" style="cursor:pointer"><i class="fa fa-gift"></i> Packages</a>
  <a href="atv.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="ATV's" style="cursor:pointer"><i class="fa fa-barcode"></i> Activate</a>
  <a href="product-list.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Market Place" style="cursor:pointer"><i class="fa fa-store"></i> Market Place</a>
  <a href="forum.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Forums" style="cursor:pointer"><i class="fa fa-newspaper"></i> Forums</a>
  <a href="pair_charts.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Pair Charts" style="cursor:pointer"><i class="fa fa-chart-line"></i> Charts</a>
  <a href="trainings.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Trainings" style="cursor:pointer"><i class="fa fa-graduation-cap"></i> Trainings</a>
  <?php if(!isset($_SESSION['username'])) {
	  echo '
  <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white w3-text-green" title="Login/Register" style="float: right"><i class="fa fa-laptop"></i> Login/Register</a>' ;
  }else { echo '
  <a href="logout.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white w3-text-red" title="Logout" style="float: right"><i class="fa fa-user-lock"></i> Logout</a>
  <a href="settings.php?clickedset=profile" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white w3-text-green" title="Settings" style="float: right"><i class="fa fa-gears"></i> Settings</a>
  <a href="support.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white w3-text-blue" title="Support" style="float: right"><i class="fa fa-head-phone"></i> Support</a>
  <a href="notifications.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white w3-text-blue" title="Notifications" style="float: right"><i class="fa fa-bullhorn"><sup> 0</sup></i> Notifications</a>' ; } ?>
 </div>
</div>
<!-- Navbar on small screens -->
    
<!-- Newsletter Modal -->
<div id="newsletter" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
      <div class="w3-container w3-white w3-center">
        <i onclick="document.getElementById('newsletter').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
        <h2 class="w3-wide">NEWSLETTER</h2>
        <p>Join our mailing list to receive updates on new arrivals and special offers.</p>
        <p><input class="w3-input w3-border" type="text" placeholder="Enter e-mail" required></p>
        <button type="button" class="fa fa-paper-plane w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('newsletter').style.display='none'"> Subscribe</button>
      </div>
    </div>
  </div>



  <nav class="w3-sidebar w3-hide-medium w3-hide-large w3-bar-block w3-card" id="mySidebar">
<div class="w3-container w3-theme-d2">
  <span onclick="closeSidebar()" class="w3-button w3-display-topright w3-large">X</span>
  <br>
  <div class="w3-padding w3-center">
  <?php if(isset($_SESSION['username'])) {
	  echo '
  <a href="mypage.php"><img class="w3-circle" src="images/logo.png" alt="Connect" style="width:75%"></a>' ;
  }else { echo '
  <a href="index.php"><img class="w3-circle" src="images/logo.png" alt="Connect" style="width:75%"></a>' ;
  } ?>
  </div>
</div>
  <?php if(isset($_SESSION['username'])) {
	  echo '' ;
  }else { echo '
<a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" style="cursor:pointer" title="Home"><i class="fa fa-home"> Home</i></a>' ;
  } ?>
<a href="mypage.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" style="cursor:pointer" title="Feeds"><i class="fa fa-book"> Feeds</i></a>
<a href="acc_settings.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" style="cursor:pointer" title="Profile"><i class="fa fa-dashboard"> Dashboard</i></a>
  <a href="package.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" style="cursor:pointer" title="Packages"><i class="fa fa-gift"> Packages</i></a>
  <a href="atv.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" style="cursor:pointer" title="ATV's"><i class="fa fa-barcode"> Activate</i></a>
  <a href="product-list.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" style="cursor:pointer" title="Market Place"><i class="fa fa-money"> Market Place</i></a>
  <a href="forum.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" title="Forums"><i class="fa fa-group"> Forums</i></a>
  <a href="pair_charts.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large" title="Pair Charts"><i class="fa fa-bar-chart"> Charts</i></a>
  <?php if(!isset($_SESSION['username'])) {
	  echo '
<a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-text-green" style="cursor:pointer" title="Login/Register"><i class="fa fa-laptop"> Login/Register</i></a>' ;
  }else { echo '
<a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-text-red" style="cursor:pointer" title="Logout"><i class="fa fa-sign-out"> Logout</i></a>' ;
  } ?><br><br><br><br><br><br><br><br><br><br>
<div class="col-sm-3 text-center" id="google_translate_element" style="display: inline-block; z-index: 5"></div><br>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" onclick="document.getElementById('newsletter').style.display='block'"><i class="fa fa-envelope"> NEWSLETTER</i></a>
</nav>

<header class="w3-bar w3-hide-medium w3-hide-large w3-card w3-theme-d2">
  <button class="w3-bar-item w3-button w3-xxlarge w3-hover-theme" onclick="openSidebar()">&#9776;</button>
  <h1 class="w3-bar-item"><a href="mypage.php"><img class="w3-circle" src="images/logo.png" alt="Connect" style="width:100%"></a></h1>
</header>


<script>
closeSidebar();
function openSidebar() {
  document.getElementById("mySidebar").style.display = "block";
}

function closeSidebar() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>

	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement({
				pageLanguage: 'en',
				layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			}, 'google_translate_element');
		}
	</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
