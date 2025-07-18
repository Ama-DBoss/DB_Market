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
 <div class="w3-bar w3-theme-d2 w3-right-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="index.php" class="w3-bar-item w3-padding-large w3-theme-d2"><img class="w3-circle" src="images/logo.png" alt="Connect" ></a>
              <?php if (isset($_SESSION['username'])) : ?>
  <a href="acc_settings.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="Profile">My Account</a>
<?php else : ?>
  <a href="signin.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="lg">Login/Register</a>
<?php endif; ?>

  <a href="forum.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="Forums">Forums</a>
  <a href="product-list.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="Market Place">Market Place</a>
  <a href="contact.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="Contact">Contact Us</a>
  <a href="tnc.php#pp" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="PP">Privacy Policy</a>
  <a href="tnc.php#faq" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="Faq">Faq's</a>
  <a href="tnc.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="tnc">TnC</a>
  <a href="about.php" class="w3-bar-item w3-hide-small w3-right w3-padding-large" style="text-decoration:none" title="About">About Us</a>
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
  <a href="index.php"><img class="w3-circle" src="images/logo.png" alt="Connect" style="width:75%"></a>
  </div>
</div>
<a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="Home"><i class="fa fa-home"> Home</i></a>
<a href="about.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="About"><i class="fa fa-globe"> About</i></a>
  <a href="tnc.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="TNC"><i class="fa fa-gift"> TnC</i></a>
  <a href="tnc.php#faq" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="FAQ's"><i class="fa fa-question"> Faq's</i></a>
    <a href="tnc.php#pp" onclick="w3_close()" class="w3-bar-item w3-button w3-right w3-padding-large w3-hover-grey" title="PP"><i class="fa fa-eye-slash"> Privacy Policy</i>
  <a href="signin.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="signin"><i class="fa fa-sign-in"> LOGIN</i></a>
  <a href="register.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="register"><i class="fa fa-laptop"> REGISTER</i></a></a><br><br><br><br><br><br><br><br><br><br>
    <a href="contact.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey"><i class="fa fa-headphones"> CONTACT</i></a>
<a href="product-list.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="Market Place"><i class="fa fa-money"> MARKET PLACE</i></a>
<a href="forum.php" onclick="w3_close()" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" title="Forums"><i class="fa fa-money"> FORUMS</i></a>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-large w3-hover-grey" onclick="document.getElementById('newsletter').style.display='block'"><i class="fa fa-envelope"> NEWSLETTER</i></a>
</nav>

<header class="w3-bar w3-hide-medium w3-hide-large w3-card w3-theme-d2">
  <button class="w3-bar-item w3-button w3-xxlarge w3-hover-theme" onclick="openSidebar()">&#9776;</button>
  <h1 class="w3-bar-item"><a href="index.php"><img class="w3-circle" src="images/logo.png" alt="Connect" style="width:100%"></a></h1>
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