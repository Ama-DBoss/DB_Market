<?php
// Database connection
require_once 'includes/db.con.php';
include 'includes/functions.php';
//include ('server.php');

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

function maskDob($dob) {
    $year = substr($dob, 0, 4); // Extract year from date (assuming format Y-m-d)
    return '****-' . substr($dob, 5, 2) . '-' . substr($dob, 8, 2); // Mask year
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
    <style>
        .product {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
        }
        .product img {
            max-width: 100%;
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
		 
	if (isset($_GET['selcat'])) {
		$clickedlcat = mysqli_real_escape_string($DBconn, $_GET['selcat']);
		$na = 'Name (A-Z)';
		$nd = 'Name (Z-A)';
		$pa = 'Price (Low-High)';
		$pd = 'Price (High-Low)';
		$da = 'Recently Added Items';
		$dd = 'Old Items (Over a month)';
		global $clickedlcat;
		
		if ($clickedlcat === $na) {
 
		$sql = "SELECT * FROM sales ORDER BY product_name ASC";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
				}
			}
		}elseif ($clickedlcat === $nd) {
 
		$sql = "SELECT * FROM sales ORDER BY product_name DESC";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']);
				}
			}
		}elseif ($clickedlcat === $pa) {
 
		$sql = "SELECT * FROM sales ORDER BY product_price ASC";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']);
				}
			}
		}elseif ($clickedlcat === $pd) {
 
		$sql = "SELECT * FROM sales ORDER BY product_price DESC";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']);
				}
			}
		}elseif ($clickedlcat === $da) {
 
		$sql = "SELECT * FROM sales ORDER BY id DESC";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
				}
			}
		}elseif ($clickedlcat === $dd) {
 
		$sql = "SELECT * FROM sales ORDER BY id ASC";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
				}
			}
		}else{
 
		$sql = "SELECT * FROM sales WHERE category_name='$clickedlcat' OR stock_location='$clickedlcat'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
				}
			}
		}
	}

		global $clickedlcat;
		global $na;
		global $nd;
		global $pa;
		global $pd;
		global $da;
		global $dd;
?>
    
<?php
		 
	if (isset($_GET['clickedvnd'])) {
		$clickedlvdn = mysqli_real_escape_string($DBconn, $_GET['clickedvnd']);
		global $clickedlvdn;
 
		$sql = "SELECT * FROM sales WHERE vendor_uname='$clickedlvdn'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
	} } }

		global $clickedlvdn;
					

		 
	if (isset($_GET['selcat'])) {
		$clickedlcat = mysqli_real_escape_string($DBconn, $_GET['selcat']);
		global $clickedlvdn;
		global $clickedlcat;
 
		$sql = "SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' AND category_name='$clickedlcat'";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					//$pc = htmlspecialchars($row['category_name']); 
	} } }

		global $clickedlcat;
					
	$pvsql = "SELECT * FROM promote WHERE creator_un = '$clickedlvdn' LIMIT 1";
	$pvresult = $DBconn->query($pvsql);
		if ($pvresult->num_rows > 0) {
			$verified = "Verified";
		}
		global $verified;
?>

<!-- Page Container -->
<div class="w3-display-container w3-content" style="max-width:1600px; margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">

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
?>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white w3-animate-zoom w3-center" style="
  background-image: url('uploads/store/banners/<?php echo $storeban; ?>');
  min-height: 100%;
  width:100%;
  background-position: center;
  background-size: cover;">
  <?php
	if (!empty($verified)) {
		echo'
          <span class="w3-tag w3-right w3-theme-d2 w3-padding"><i class="fa fa-check"></i> '. $verified .'</span>
		  ';
	}else {
		echo '
		';
	}
	?>

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
?>
</div>
    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-display-container" style="padding:10px 10px">
	<p><h1 class="w3-text-red"><?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>
         <hr class="" style="border: 1px solid">

<?php
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' OR category_name='$clickedlvdn' ORDER BY id DESC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$clickedlvdn' OR vendor_id='$clickedlvdn' OR category_name='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;
?>

<?php
		if ($clickedlcat === $na) {
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' ORDER BY product_name ASC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;

		}elseif ($clickedlcat === $nd) {
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' ORDER BY product_name DESC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;

		}elseif ($clickedlcat === $pa) {
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' ORDER BY product_price ASC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;

		}elseif ($clickedlcat === $pd) {
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' ORDER BY product_price DESC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;

		}elseif ($clickedlcat === $da) {
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' ORDER BY id DESC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;

		}elseif ($clickedlcat === $dd) {
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE vendor_uname='$clickedlvdn' ORDER BY id ASC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;

		}else{
  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE category_name='$clickedlcat' AND vendor_uname='$clickedlvdn' OR stock_location='$clickedlcat' AND vendor_uname='$clickedlvdn' ORDER BY id DESC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE category_name='$clickedlcat' AND vendor_uname='$clickedlvdn' OR stock_location='$clickedlcat' AND vendor_uname='$clickedlvdn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;
		}
?>
		 
		 <div class="w3-row">
		 <div class="w3-col m2">
		<fieldset>
		<h2 class="w3-center"><u><b>SORT / FILTER</b></u></h2>
		<h2><u><b>BY CATEGORIES</b></u></h2>
		<?php
        $plquery = "SELECT * FROM categories ORDER BY category_name ASC";
        $plresults = mysqli_query($DBconn, $plquery);

        if ($plresults && mysqli_num_rows($plresults) > 0) {
            while ($row = mysqli_fetch_assoc($plresults)) {
				$cats = htmlspecialchars($row['category_name']);
				$icon = htmlspecialchars($row['fav']);
				?>
			<label title="<?php echo $cats; ?>" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=<?php echo $cats; ?>'">
			<i class="fa fa-<?php echo $icon; ?>"></i> <?php echo $cats; ?>
			</label><br>
			<?php
		} }
		global $cats;
		?>
			<label title="Show All" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>'">
			<i class="fa fa-globe"></i> Show All
			</label><br>
		
         <hr class="" style="border: 1px solid">
		 
		<h2><u><b>BY VARIABLES</b></u></h2>
		<select class="w3-text-blue" name="sort_prod" style="width:90%" required>
			<option value="">--Sort Items--</option>
				<option value="Name (A-Z)" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Name (A-Z)'">Name (A-Z)</option>
				<option value="Name (Z-A)" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Name (Z-A)'">Name (Z-A)</option>
				<option value="Price (Low-High)" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Price (Low-High)'">Price (Low-High)</option>
				<option value="Price (High-Low)" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Price (High-Low)'">Price (High-Low)</option>
				<option value="Recently Added Items" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Recently Added Items'">Recently Added Items</option>
				<option value="Old Items (Over a month)" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Old Items (Over a month)'">Old Items (Over a month)</option>
		</select><br>
		
         <hr class="" style="border: 1px solid">
		 
		<h2><u><b>BY LOCATION</b></u></h2>
		<select class="w3-text-blue" name="sort_prod" style="width:90%" required>
			<option value="">--Select Location--</option>
				<option value="Abia" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Abia'">Abia</option>
				<option value="Adamawa" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Adamawa'">Adamawa</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Akwa-Ibom'">Akwa-Ibom</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Anambra'">Anambra</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Bauchi'">Bauchi</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Bayelsa'">Bayelsa</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Benue'">Benue</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Borno'">Borno</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Cross-Rivers'">Cross-Rivers</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Delta'">Delta</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Ebonyi'">Ebonyi</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Edo'">Edo</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Ekiti'">Ekiti</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Enugu'">Enugu</option>
				<option value="FCT" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=FCT'">FCT</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Gombe'">Gombe</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Imo'">Imo</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Jigawa'">Jigawa</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Kaduna'">Kaduna</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Kano'">Kano</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Kebbi'">Kebbi</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Kogi'">Kogi</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Kwara'">Kwara</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Lagos'">Lagos</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Nasarawa'">Nasarawa</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Niger'">Niger</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Ogun'">Ogun</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Ondo'">Ondo</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Osun'">Osun</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Oyo'">Oyo</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Plateau'">Plateau</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Rivers'">Rivers</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Sokoto'">Sokoto</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Taraba'">Taraba</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Yobe'">Yobe</option>
				<option value="Name" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>&selcat=Zamfara'">Zamfara</option>
		</select><br>
		
         <hr class="" style="border: 1px solid">
		
		<h2><u><b>BY VENDORS</b></u></h2>
		<?php
        $plquery = "SELECT * FROM store ORDER BY RAND() LIMIT 10";
        $plresults = mysqli_query($DBconn, $plquery);

        if ($plresults && mysqli_num_rows($plresults) > 0) {
            while ($row = mysqli_fetch_assoc($plresults)) {
				$storen = htmlspecialchars($row['store_name']);
				?>
			<label title="<?php echo $storen; ?>" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo htmlspecialchars($row['creator_un']); ?>'">
			<i class="fa fa-store"></i> <?php echo strtolower($storen); ?>
			</label><br>
			<?php
		} }
		global $cats;
		?>
			<label title="Show All" class="w3-text-blue" style="cursor:pointer; size:12px" 
			type="button" onclick="window.location.href='vendors.php?clickedvnd=<?php echo $clickedlvdn; ?>'">
			<i class="fa fa-globe"></i> Show All
			</label><br><br>
		</fieldset>
		 </div>

<script>
    function searchCat(categoryName) {
		
		var x = document.getElementById('mainview');
		if (x.style.display === 'block') {
			x.style.display = 'none';
		}else{
			x.style.display = 'block';
		}
    }
</script>

			<?php

if (isset($_POST['searchprobtn'])) {
    $errors = []; // Ensure the errors array is initialized
    // Sanitize inputs
	$vts = mysqli_real_escape_string($DBconn, $_GET['clickedvnd']);
    $psn = mysqli_real_escape_string($DBconn, $_POST['searchpro']);

  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE product_name = ?  AND vendor_uname = ? OR product_name LIKE ? AND vendor_uname = ? LIMIT ? OFFSET ?");
  $stmt->bind_param('ssssii', $psn, $vts, $psn, $vts, $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE product_name = '$psn'  AND vendor_uname = '$vts' OR product_name LIKE '$psn' AND vendor_uname = '$vts' ");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;
	?>
	
		<div class="w3-col m10">
			<fieldset id="mainview">
			<!-- Search and Filter Form -->
			<form method="POST" action="" enctype="multipart/form-data">
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="searchpro" placeholder="Search by products name" required><br><br>
				<button class="w3-padding w3-round-large w3-green" name="searchprobtn" id="searchprobtn" type="submit"><i class="fa fa-search"></i> Search</button>
			</form>
				<button class="w3-padding w3-round-large w3-blue" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo $clickedlvdn; ?>'"><i class="fa fa-globe"></i> Show All</button>
			</fieldset>
			
<div class="w3-display-container">
<?php
if (!$clickedlcat AND !isset($_POST['searchprobtn'])){
	echo '
<label class="w3-left w3-padding w3-text-blue">ALL ITEMS</label>';
}else{
	if ($clickedlcat) {
	echo '
<label class="w3-left w3-padding w3-text-blue">Items Sort By Product Name: '. htmlspecialchars(strtoupper($clickedlcat)) .'</label>
';
	}else{
	if (isset($_POST['searchprobtn'])) {
	echo '
<label class="w3-left w3-padding w3-text-blue">Items Sort By Product Name: '. htmlspecialchars(strtoupper($psn)) .'</label>
';
	}
	}
} ?>

<?php
if ($total_items < 1 ) {
	echo '
<label class="w3-right w3-padding w3-text-red">Total Items Found: '. htmlspecialchars($total_items) .'</label>
';
}else {
	echo '
<label class="w3-right w3-padding w3-text-green">Total Items Found: '. htmlspecialchars($total_items) .'</label>
	';
}
function trimText($text, $maxLength = 50, $suffix = '...') {
    if (mb_strlen($text) > $maxLength) {
        return mb_strimwidth($text, 0, $maxLength, $suffix);
    }
    return $text;
}
?>
    <div class="w3-row-padding w3-margin-top">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
		    <style>
        .products {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
        }
        .products img {
            max-width: 100%;
            cursor: pointer;
        }
        .descriptions {
            display: none;
        }
    </style>
            <div class="w3-quarter w3-margin-bottom">
                <div class="w3-card w3-white w3-round-large">
                    <div class="products">
                        <!-- Display Product Images -->
                        <div>
                        <?php 
                        // Decode and display images
                        $images = json_decode($row['product_image'], true);
                        if (!empty($images)) {
                            echo "<div class='post-images'>";
                            
                            // Display the first image as the parent image
                            echo "<div class='parent-image'>";
                            echo "<img title='". htmlspecialchars(strtoupper($row['product_name'])) ."' id='parentImage' class='w3-round-large' src='uploads/products/" . htmlspecialchars($images[0]) . "' alt='Parent Image' onclick='showDescription(". $row['id'] .")' style='width:100%; height:200px; cursor:pointer;'>";
                            echo "</div>";

                            echo "</div>";
                        }
                        ?>
                        </div>

                        <!-- Product Details -->
					<form action="product_view.php" method="GET" enctype="multipart/form-data">
						<p>
						<?php
						// Example usage
						$labelText = $row['product_name'];
						$trimmedText = trimText($labelText, 25); // Trims to 30 characters ?>
						<label title="<?php echo htmlspecialchars(strtoupper($row['product_name'])); ?>" style="cursor:pointer" class="w3-text-blue" type="button" onclick="window.location.href='product_view.php?clickedad=<?php echo htmlspecialchars($row['product_name']); ?>'"><?php echo htmlspecialchars(strtoupper($trimmedText)); ?></label><br>
                        <label class="w3-text-blue-grey"><b>Price:</b> ₦<?php echo number_format(htmlspecialchars($row['product_price']),2); ?></label><br>
                        <label class="w3-text-blue-grey"><b>Category:</b> <?php echo htmlspecialchars($row['category_name']); ?></label><br>
                        <label class="w3-text-blue-grey"><b>Condition:</b> <?php echo $row['product_condition']; ?> </label>
						</p>
                    </form>

                        <!-- Hidden Description (Toggled on Click) -->
                        <div id="description-<?php echo $row['id']; ?>" 
                             class="description" 
                             style="display:none; margin-top:10px;">
                            <p><b><u>PRODUCT DESCRIPTION</u></b><br><?php echo htmlspecialchars($row['product_description']); ?></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="w3-margin-top w3-center">
                            <!-- WhatsApp Button with Pre-filled Message -->
                            <a href="https://wa.me/<?php echo htmlspecialchars($row['vendor_pno'])?>?text=<?php echo urlencode(
                                'Hello, I am interested in the following product: ' . 
                                "\nProduct Name: " . htmlspecialchars($row['product_name']) . 
                                "\nPrice: ₦" . htmlspecialchars($row['product_price']) . 
                                "\nCategory: " . htmlspecialchars($row['category_name']) . 
                                "\nPlease provide more details or let me know how to proceed."
                            ); ?>" 
                               target="_blank" 
                               class="whatsapp">
                                <button class="w3-button w3-round-large w3-green w3-ripple">
                                    <i class="fa fa-message" style="padding-right: 5px;"></i>Chat
                                </button>
                            </a>
							<a href="tel:<?php echo htmlspecialchars($row['vendor_pno'])?>"><button class="w3-button w3-round-large w3-green w3-ripple">
								<i class="fa fa-mobile" style="padding-right: 5px;"></i>Call
							</button></a>

                            <!-- Save to Wishlist Button -->
							<?php if(!isset($_SESSION['username'])){
								echo '<button onclick="redirectToLogin()" class="w3-button w3-round-large w3-purple w3-ripple">
    <i class="fa fa-heart" style="padding-right: 5px;"></i>Save</button>';
							}else{
								echo '<button class="w3-button w3-round-large w3-purple w3-ripple save-to-wishlist" data-product-id="'. $row['id'] .'"><i class="fa fa-heart" style="padding-right: 5px;"></i>Save</button>';
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
	<script>
		function redirectToLogin() {
			alert('Please login to save items to your wishlist.');
			window.location.href = 'login.php';
		}
	</script>
                <hr style="border: 1px solid">
				<!-- Pagination -->
<div class="w3-container w3-center" style="margin: 20px 0;">
   <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
         <?php if ($current_page > 1): ?>
            <li class="page-item">
               <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
               </a>
            </li>
         <?php endif; ?>

         <?php 
         // Display a range of pages around the current page
         $range = 2; // Adjust this value for more or fewer surrounding pages
         $start = max(1, $current_page - $range);
         $end = min($total_pages, $current_page + $range);

         if ($start > 1): ?>
            <li class="page-item">
               <a class="page-link" href="?page=1">1</a>
            </li>
            <?php if ($start > 2): ?>
               <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
         <?php endif; ?>

         <?php for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
               <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
         <?php endfor; ?>

         <?php if ($end < $total_pages): ?>
            <?php if ($end < $total_pages - 1): ?>
               <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
            <li class="page-item">
               <a class="page-link" href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
            </li>
         <?php endif; ?>

         <?php if ($current_page < $total_pages): ?>
            <li class="page-item">
               <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
               </a>
            </li>
         <?php endif; ?>
      </ul>
   </nav>
</div>
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
</style>
</div>
  </div>
		 

	<?php
}else{
	?>
	
		<div class="w3-col m10">
			<fieldset id="mainview">
			<!-- Search and Filter Form -->
			<form method="POST" action="" enctype="multipart/form-data">
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="searchpro" placeholder="Search by products name" required><br><br>
				<button class="w3-padding w3-round-large w3-green" name="searchprobtn" id="searchprobtn" type="submit"><i class="fa fa-search"></i> Search</button>
			</form>
			</fieldset>
			
<div class="w3-display-container">
<?php
if (!$clickedlcat AND !isset($_GET['searchprobtn'])){
	echo '
<label class="w3-left w3-padding w3-text-blue">ALL ITEMS</label>';
}else{
	if ($clickedlcat) {
	echo '
<label class="w3-left w3-padding w3-text-blue">Items Sort By: '. htmlspecialchars(strtoupper($clickedlcat)) .'</label>
';
	}else{
	if (isset($_GET['searchprobtn'])) {
	echo '
<label class="w3-left w3-padding w3-text-blue">Items Sort By: '. htmlspecialchars(strtoupper($psn)) .'</label>
';
	}
	}
} ?>

<?php
if ($total_items < 1 ) {
	echo '
<label class="w3-right w3-padding w3-text-red">Total Items Found: '. htmlspecialchars($total_items) .'</label>
';
}else {
	echo '
<label class="w3-right w3-padding w3-text-green">Total Items Found: '. htmlspecialchars($total_items) .'</label>
	';
}
function trimText($text, $maxLength = 50, $suffix = '...') {
    if (mb_strlen($text) > $maxLength) {
        return mb_strimwidth($text, 0, $maxLength, $suffix);
    }
    return $text;
}
?>
    <div class="w3-row-padding w3-margin-top">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
		    <style>
        .products {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
        }
        .products img {
            max-width: 100%;
            cursor: pointer;
        }
        .descriptions {
            display: none;
        }
    </style>
            <div class="w3-quarter w3-margin-bottom">
                <div class="w3-card w3-white w3-round-large">
                    <div class="products">
                        <!-- Display Product Images -->
                        <div>
                        <?php 
                        // Decode and display images
                        $images = json_decode($row['product_image'], true);
                        if (!empty($images)) {
                            echo "<div class='post-images'>";
                            
                            // Display the first image as the parent image
                            echo "<div class='parent-image'>";
                            echo "<img title='". htmlspecialchars(strtoupper($row['product_name'])) ."' id='parentImage' class='w3-round-large' src='uploads/products/" . htmlspecialchars($images[0]) . "' alt='Parent Image' onclick='showDescription(". $row['id'] .")' style='width:100%; height:200px; cursor:pointer;'>";
                            echo "</div>";

                            echo "</div>";
                        }
                        ?>
                        </div>

                        <!-- Product Details -->
					<form action="product_view.php" method="GET" enctype="multipart/form-data">
						<p>
						<?php
						// Example usage
						$labelText = $row['product_name'];
						$trimmedText = trimText($labelText, 25); // Trims to 30 characters ?>
						<label title="<?php echo htmlspecialchars(strtoupper($row['product_name'])); ?>" style="cursor:pointer" class="w3-text-blue" type="button" onclick="window.location.href='product_view.php?clickedad=<?php echo htmlspecialchars($row['product_name']); ?>'"><?php echo htmlspecialchars(strtoupper($trimmedText)); ?></label><br>
                        <label class="w3-text-blue-grey"><b>Price:</b> ₦<?php echo number_format(htmlspecialchars($row['product_price']),2); ?></label><br>
                        <label class="w3-text-blue-grey"><b>Category:</b> <?php echo htmlspecialchars($row['category_name']); ?></label><br>
                        <label class="w3-text-blue-grey"><b>Condition:</b> <?php echo $row['product_condition']; ?> </label>
						</p>
                    </form>

                        <!-- Hidden Description (Toggled on Click) -->
                        <div id="description-<?php echo $row['id']; ?>" 
                             class="description" 
                             style="display:none; margin-top:10px;">
                            <p><b><u>PRODUCT DESCRIPTION</u></b><br><?php echo htmlspecialchars($row['product_description']); ?></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="w3-margin-top w3-center">
                            <!-- WhatsApp Button with Pre-filled Message -->
                            <a href="https://wa.me/<?php echo htmlspecialchars($row['vendor_pno'])?>?text=<?php echo urlencode(
                                'Hello, I am interested in the following product: ' . 
                                "\nProduct Name: " . htmlspecialchars($row['product_name']) . 
                                "\nPrice: ₦" . htmlspecialchars($row['product_price']) . 
                                "\nCategory: " . htmlspecialchars($row['category_name']) . 
                                "\nPlease provide more details or let me know how to proceed."
                            ); ?>" 
                               target="_blank" 
                               class="whatsapp">
                                <button class="w3-button w3-round-large w3-green w3-ripple">
                                    <i class="fa fa-message" style="padding-right: 5px;"></i>Chat
                                </button>
                            </a>
							<a href="tel:<?php echo htmlspecialchars($row['vendor_pno'])?>"><button class="w3-button w3-round-large w3-green w3-ripple">
								<i class="fa fa-mobile" style="padding-right: 5px;"></i>Call
							</button></a>

                            <!-- Save to Wishlist Button -->
							<?php if(!isset($_SESSION['username'])){
								echo '<button onclick="redirectToLogin()" class="w3-button w3-round-large w3-purple w3-ripple">
    <i class="fa fa-heart" style="padding-right: 5px;"></i>Save</button>';
							}else{
								echo '<button class="w3-button w3-round-large w3-purple w3-ripple save-to-wishlist" data-product-id="'. $row['id'] .'"><i class="fa fa-heart" style="padding-right: 5px;"></i>Save</button>';
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
	<script>
		function redirectToLogin() {
			alert('Please login to save items to your wishlist.');
			window.location.href = 'login.php';
		}
	</script>
                <hr style="border: 1px solid">
				<!-- Pagination -->
<div class="w3-container w3-center" style="margin: 20px 0;">
   <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
         <?php if ($current_page > 1): ?>
            <li class="page-item">
               <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
               </a>
            </li>
         <?php endif; ?>

         <?php 
         // Display a range of pages around the current page
         $range = 2; // Adjust this value for more or fewer surrounding pages
         $start = max(1, $current_page - $range);
         $end = min($total_pages, $current_page + $range);

         if ($start > 1): ?>
            <li class="page-item">
               <a class="page-link" href="?page=1">1</a>
            </li>
            <?php if ($start > 2): ?>
               <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
         <?php endif; ?>

         <?php for ($i = $start; $i <= $end; $i++): ?>
            <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
               <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
         <?php endfor; ?>

         <?php if ($end < $total_pages): ?>
            <?php if ($end < $total_pages - 1): ?>
               <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
            <li class="page-item">
               <a class="page-link" href="?page=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a>
            </li>
         <?php endif; ?>

         <?php if ($current_page < $total_pages): ?>
            <li class="page-item">
               <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
               </a>
            </li>
         <?php endif; ?>
      </ul>
   </nav>
</div>
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
</style>
</div>
  </div>
	<?php } ?>
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