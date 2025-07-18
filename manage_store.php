<?php
// Database connection
require_once 'includes/db.con.php';
include 'includes/functions.php';
//include ('server.php');

  $errors = array(); 
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION['username'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
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

// Search and Filter Logic
$searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : '';
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000000;

// Build query dynamically
$query = "SELECT sales.*, categories.category_name FROM sales 
          JOIN categories ON sales.category_id = categories.id WHERE 1=1";

if (!empty($searchQuery)) {
    $query .= " AND (sales.product_name LIKE '%$searchQuery%' OR sales.product_description LIKE '%$searchQuery%')";
}
if (!empty($categoryFilter)) {
    $query .= " AND sales.category_id = $categoryFilter";
}
if ($minPrice > 0 || $maxPrice < 10000000) {
    $query .= " AND sales.product_price BETWEEN $minPrice AND $maxPrice";
}

$query .= " ORDER BY sales.created_at DESC";
$result = mysqli_query($DBconn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<title>Connect | Affiliate Marketing</title>
<meta name="description" content="Number one online platform to earn passive income, while enjoying the extra look and feel of a social media and ecommerce platform">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Number one online platform to earn passive income, while enjoying the extra look and feel of a social media and ecommerce platform">
<meta name="author" content="Connect Affiliate Resource Media">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
<meta property="og:title" content="Connect Affiliate Resource Media">
<meta property="og:description" content="Number one online platform to earn passive income, while enjoying the extra look and feel of a social media and ecommerce platform">
<meta property="og:image" content="/connect/images/og-image.jpg">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
<meta property="twitter:title" content="Connect Affiliate Resource Media">
<meta property="twitter:description" content="Number one online platform to earn passive income, while enjoying the extra look and feel of a social media and ecommerce platform">
<meta property="twitter:image" content="/connect/images/twitter-image.jpg">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="/connect/images/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/connect/images/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/connect/images/favicon/favicon-16x16.png">
<link rel="manifest" href="/connect/images/favicon/site.webmanifest">
<link rel="mask-icon" href="/connect/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/pagination.css">
<link rel="stylesheet" href="css/mycss.css">
<link rel="stylesheet" href="css/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="js/new_myjs.js" defer></script>
    <style>
        .product {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
        }
        .product img {
            max-width: 200px;
            cursor: pointer;
        }
        .description {
            display: none;
        }
    </style>
</head>
<body class="w3-theme-l5">
    
    <!-- Navigation Bar -->
	<?php if(isset($_SESSION['username'])) : ?>
		<?php include_once "includes/nav.php"; ?>
	<?php else : ?>
		<?php include_once "includes/pubnav.php"; ?>
	<?php endif ?>
    
<?php
		 
//	if (isset($_GET['clickedvnd'])) {
	$clickedlvdn = $_SESSION['username'];
		global $clickedlvdn;
 
		$sql = "SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' OR vendor_id='$clickedlvdn'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
	} }
	//}

		global $clickedlvdn;
					
?>

<!-- Page Container -->
<div class="w3-display-container w3-content" style="max-width:1600px; margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">

<?php
	$sql = "SELECT * FROM store WHERE creator_un ='$clickedlvdn'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
				$storename = htmlspecialchars($row['store_name']);
				$storenumb = htmlspecialchars($row['store_number']);
				$storewapp = htmlspecialchars($row['store_whatsapp']);
				$storeloc = htmlspecialchars($row['store_location']);
				$storedesc = htmlspecialchars($row['store_desc']);
				$storeban = htmlspecialchars($row['store_banner']);
				$storelogo = htmlspecialchars($row['store_logo']);
				$storefb = htmlspecialchars($row['store_fb']);
				$storeig = htmlspecialchars($row['store_ig']);
				$storesc = htmlspecialchars($row['store_sc']);
				$storetk = htmlspecialchars($row['store_tk']);
				$storeyt = htmlspecialchars($row['store_yt']);
				
				global $storename;
?>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white w3-animate-zoom w3-center" style="
  background-image: url('uploads/store/banners/<?php echo $storeban; ?>');
  min-height: 100%;
  width:100%;
  background-position: center;
  background-size: cover;">

<br>
		<a class="w3-wide w3-center" href="profile.php?clickedac=<?php echo htmlspecialchars($clickedlvdn); ?>" style="text-decoration:none">
		<img class="w3-wide w3-center" id='parentImage' src='uploads/store/logos/<?php echo $storelogo; ?>' alt='Store Logo Image' style='width:200px; height:200px; border-radius:50%; cursor:pointer;'>
			<h2 class="w3-wide w3-center"><?php echo "$storename"; ?></h2>
		</a>
		<h5 class="w3-wide w3-center">
			<a href="tel:<?php echo "$storenumb"; ?>" style="text-decoration:none">
				<i class="fa fa-mobile" style="padding-right: 5px;"></i> <?php echo "$storenumb"; ?>
			</a> | 
			<a href="https://wa.me/<?php echo "$storewapp"; ?>?text=<?php echo urlencode(
				'Hello, ' . htmlspecialchars($row['store_name'])
			); ?>" 
			   target="_blank" 
			   class="whatsapp" style="text-decoration:none">
				<i class="fa fa-whatsapp" style="padding-right: 5px;"></i> <?php echo "$storewapp"; ?>
			</a>
		</h5>
		<h5 class="w3-wide w3-center">
			<a href="https://facebook.com/<?php echo "$storefb"; ?>" target="_blank" class="facebook" style="text-decoration:none">
				<i class="fa fa-facebook" style="padding-right: 5px;"></i> <?php echo "$storefb"; ?></a> | 
            <a href="https://instagram.com/<?php echo "$storeig"; ?>" target="_blank" class="instagram" style="text-decoration:none">
				<i class="fa fa-instagram" style="padding-right: 5px;"></i> <?php echo "$storeig"; ?></a> | 
            <a href="https://snapchat.com/<?php echo "$storesc"; ?>" target="_blank" class="snapchat" style="text-decoration:none">
				<i class="fa fa-snapchat" style="padding-right: 5px;"></i> <?php echo "$storesc"; ?></a> | 
            <a href="https://tiktok.com/<?php echo "$storetk"; ?>" target="_blank" class="tiktok" style="text-decoration:none">
				<i class="fa fa-tiktok" style="padding-right: 5px;"></i> <?php echo "$storetk"; ?></a> | 
            <a href="https://youtube.com/<?php echo "$storeyt"; ?>" target="_blank" class="youtube" style="text-decoration:none">
				<i class="fa fa-youtube" style="padding-right: 5px;"></i> <?php echo "$storeyt"; ?></a>
		</h5>
		<h5 class="w3-wide w3-center"><?php echo "$storeloc"; ?></h5>
		<h5 class="w3-wide w3-center"><?php echo "$storedesc"; ?></h5><br>
<?php
				}
			}
				global $storename;
?>
</div>
    <!-- The Grid -->
    <div class="w3-row">
  <!-- package Section -->
	<div class="w3-container" style="padding:10px">
	<p><h1 class="w3-text-red"><?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>
         <hr class="" style="border: 1px solid">
	<div class="w3-col m2">
		<fieldset>
		<h2 class="w3-center"><u><b>MENU</b></u></h2>
			<label style="cursor:pointer" type="button" name="sp" id="sp" onclick="window.location.href='product_upload.php'"><i class="fa fa-money-bill"></i> Sell Products</label><br>
			<label style="cursor:pointer" type="button" name="myp" id="myp" onclick="handleAction('myProducts')"><i class="fa fa-shopping-bag"></i> My Products</label><br>
			<label style="cursor:pointer" type="button" name="myw" id="myw" onclick="handleAction('myWishlist')"><i class="fa fa-bookmark"></i> My Wishlist</label><br>
			<label style="cursor:pointer" type="button" name="mya" id="mya" onclick="handleAction('ads')"><i class="fa fa-flag"></i> Create Ads</label><br>
			<label style="cursor:pointer" type="button" name="mypt" id="mypt" onclick="handleAction('promote')"><i class="fa fa-chart-line"></i> Promote Store</label><br>
			<label style="cursor:pointer" type="button" name="mys" id="mys" onclick="handleAction('settings')"><i class="fa fa-store"></i> Store Settings</label><br>
			<label style="cursor:pointer" type="button" name="ds" id="ds" onclick="handleAction('delStore')"><i class="fa fa-recycle"></i> Delete Store</label><br>
		</fieldset>
	</div>
    <div class="w3-col m10">
	<fieldset id="manageoutput">

	</fieldset>
	</div>
    </div>
    </div>
</div>
<button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-arrow-up" style="border-radius: 50%"></button>
<?php
    include 'includes/footer.php';
?>
<style>
.pagination {
    display: inline-flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.page-item {
    margin: 0 5px;
}

.page-item.active .page-link {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

        .preview-img {
            max-width: 300px;
            display: none;
        }
    </style>
	<script>
		function redirectToLogin() {
			alert('Please login to save items to your wishlist.');
			window.location.href = 'login.php';
		}
	</script>
<script>

    // Handle form actions dynamically
    function handleAction(action) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'vendor_actions.php', true); // Point to a PHP script that handles actions
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('manageoutput').innerHTML = xhr.responseText;
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
    }
</script>
</body>
</html>