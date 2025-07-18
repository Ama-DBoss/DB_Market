<?php
require_once 'includes/db.con.php'; // Include your database connection
include 'includes/functions.php';
include ('server.php');

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="js/new_myjs.js" defer></script>

<!-- Auto sign-outout user if inactive. -->
<script src="includes/sessionTimeout.js"></script>
</head>
<body class="w3-theme-l5">
    
<?php
    include 'includes/nav.php';
?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-container" style="padding:10px 10px">
    <h2 class="w3-wide w3-center">My Catalogue</h2>
    <p class="w3-large">
	<h1 class="w3-text-red">
	<?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>
         <hr style="border: 1px solid">

    <form id="vendorForm">
        <button type="button" name="sp" id="sp" class="w3-button w3-round-large w3-green w3-ripple w3-medium" onclick="window.location.href='product_upload.php'">Sell Products</button>
        <button type="button" name="myp" id="myp" class="w3-button w3-round-large w3-blue w3-ripple w3-medium" onclick="handleAction('myProducts')">My Products</button>
        <button type="button" name="myw" id="myw" class="w3-button w3-round-large w3-purple w3-ripple w3-medium" onclick="handleAction('myWishlist')">My Wishlist</button>
    </form>
    <div id="vendorOutput"></div><br>
	
<style>
    @media (max-width: 768px) {
        .scrollable-table {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* For smoother scrolling on iOS */
        }
        table {
            min-width: 600px; /* Ensure table content doesn't shrink too much */
        }
    }
</style>
<script>
    // Handle form actions dynamically
    function handleAction(action) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'items_gen.php', true); // Point to a PHP script that handles actions
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('vendorOutput').innerHTML = xhr.responseText;
            }
        };
        xhr.send(`action=${action}`);
    }

    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myProducts'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }

    function removeProduct(productId) {
        if (confirm("Are you sure you want to remove this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'remove_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myWishlist'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
            </script>

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