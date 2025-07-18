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

if (isset($_GET['searchvenbtn'])) {
    $errors = []; // Ensure the errors array is initialized
    // Sanitize inputs
    $vsn = mysqli_real_escape_string($DBconn, $_GET['searchven']);
	global $vsn;

    // Check if user exists in the earnings table
    $e_check_query = "SELECT * FROM store WHERE store_name = ? OR creator_un = ? OR store_name LIKE ? OR creator_un LIKE ?";
    $stmt = mysqli_stmt_init($DBconn);
    mysqli_stmt_prepare($stmt,$e_check_query);
    mysqli_stmt_bind_param($stmt, 'ssss', $vsn, $vsn, $vsn, $vsn);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
	if ($rows = mysqli_fetch_assoc($result)){

	$pvsql = "SELECT * FROM promote WHERE creator_un = '$vsn' LIMIT 1";
	$pvresult = $DBconn->query($pvsql);
		if ($pvresult->num_rows > 0) {
			$verified = "Verified";
		}
		global $verified;
	?>

<!-- Page Container -->
<div class="w3-display-container w3-content" style="max-width:1600px;margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">
    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-container" style="padding:10px 10px">
	<p><h1 class="w3-text-red"><?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>		 
		 <h2 class="w3-center"><b>VENDORS</b></h2>
         <hr class="" style="border: 1px solid">

<?php

  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM store WHERE store_name = ? OR creator_un = ? OR store_name LIKE ? OR creator_un LIKE ? ORDER BY id DESC LIMIT ? OFFSET ?");
  $stmt->bind_param("ssssii", $vsn, $vsn, $vsn, $vsn, $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM store WHERE store_name = '$vsn' OR creator_un = '$vsn' OR store_name LIKE '$vsn' OR creator_un LIKE '$vsn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;
?>
		 
		 <div class="w3-row">

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
		 
		<div class="w3-col m12">
			<fieldset id="mainview">
			<!-- Search and Filter Form -->
			<form method="GET" action="" enctype="multipart/form-data">
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="searchven" placeholder="Search Vendor's Name" required>
				<br><br>
				<button class="w3-padding w3-round-large w3-green" name="searchvenbtn" id="searchvenbtn" type="submit"><i class="fa fa-search"></i> Search</button>
			</form>
				<button class="w3-padding w3-round-large w3-blue" onclick="window.location.href='vendors.php'"><i class="fa fa-globe"></i> Show All</button>
			</fieldset>
			
<div class="w3-display-container">
<label class="w3-left w3-padding w3-text-green">ALL VENDORS</label>

<label class="w3-right w3-padding w3-text-green">Total Vendors Found: <?php echo htmlspecialchars($total_items); ?></label>

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
  <?php
	if (!empty($verified)) {
		echo'
          <span class="w3-tag w3-left w3-theme-d2 "><i class="fa fa-check"></i></span>
		  ';
	}else {
		echo '
		';
	}
	?>
		<div class="w3-quarter w3-padding-small w3-margin-bottom w3-center">
		   <img title="<?php echo htmlspecialchars($row['store_name']); ?>" id='topStores' src='uploads/store/logos/<?php echo htmlspecialchars($row['store_logo']); ?>' alt='Store Logo' onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo htmlspecialchars($row['creator_un']); ?>'" style='width:150px; height:150px; cursor:pointer; border-radius:50%'><br>
		   <label class="w3-text-blue-grey w3-center" style="cursor:pointer;" title="<?php echo htmlspecialchars($row['store_name']); ?>" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo htmlspecialchars($row['creator_un']); ?>'"><?php echo htmlspecialchars($row['store_name']); ?></label>
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
  </div>
  </div>
        </div>
    </div>
</div>

	<?php
	}else{
		?>

<!-- Page Container -->
<div class="w3-display-container w3-content" style="max-width:1600px;margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">
    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-container" style="padding:10px 10px">
	<p><h1 class="w3-text-red"><?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>		 
		 <h2 class="w3-center"><b>VENDORS</b></h2>
         <hr class="" style="border: 1px solid">

<?php

  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM store ORDER BY store_name ASC LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM store");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;
?>
		 
		 <div class="w3-row">

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
		 
		<div class="w3-col m12">
			<fieldset id="mainview">
			<!-- Search and Filter Form -->
			<form method="GET" action="" enctype="multipart/form-data">
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="searchven" placeholder="Search Vendor's Name" required>
				<br><br>
				<button class="w3-padding w3-round-large w3-green" name="searchvenbtn" id="searchvenbtn" type="submit"><i class="fa fa-search"></i> Search</button>
			</form>
				<button class="w3-padding w3-round-large w3-blue" onclick="window.location.href='vendors.php'"><i class="fa fa-globe"></i> Show All</button>
			</fieldset>
			<?php 
		echo '
		<br>
		<label class="w3-center w3-padding w3-text-red"> Sorry, No Vendor Found With The Name: '. htmlspecialchars(strtoupper($vsn)) .'.</label>
		';
		?>
			</div>
			</div>
			</div>
			</div>
			</div>
			<?php
	}
}else{

		$sql = "SELECT * FROM store";
		$result = $DBconn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$pc = htmlspecialchars($row['store_name']);
					global $pc;
				}
			}
			
			

	$pvsql = "SELECT * FROM promote WHERE store_name = '$pc'";
	$pvresult = $DBconn->query($pvsql);
		if ($pvresult->num_rows > 0) {
			$verified = "Verified";
		}
		global $verified;
?>

<!-- Page Container -->
<div class="w3-display-container w3-content" style="max-width:1600px;margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">
    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-container" style="padding:10px 10px">
	<p><h1 class="w3-text-red"><?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>		 
		 <h2 class="w3-center"><b>VENDORS</b></h2>
         <hr class="" style="border: 1px solid">

<?php

  // Define pagination variables
  $items_per_page = 20;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM store ORDER BY RAND() LIMIT ? OFFSET ?");
  $stmt->bind_param("ii", $items_per_page, $offset);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM store");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;
?>
		 
		 <div class="w3-row">

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
		 
		<div class="w3-col m12">
			<fieldset id="mainview">
			<!-- Search and Filter Form -->
			<form method="GET" action="" enctype="multipart/form-data">
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="searchven" placeholder="Search Vendor's Name" required>
				<br><br>
				<button class="w3-padding w3-round-large w3-green" name="searchvenbtn" id="searchvenbtn" type="submit"><i class="fa fa-search"></i> Search</button>
			</form>
			</fieldset>
			
<div class="w3-display-container">
<label class="w3-left w3-padding w3-text-green">ALL VENDORS</label>

<label class="w3-right w3-padding w3-text-green">Total Vendors Found: <?php echo htmlspecialchars($total_items); ?></label>

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
  <?php
	if (!empty($verified)) {
		echo'
          <span class="w3-tag w3-left w3-theme-d2 "><i class="fa fa-check"></i> '. $verified .'</span>
		  ';
	}else {
		echo '
		';
	}
	?>
		<div class="w3-quarter w3-padding-small w3-margin-bottom w3-center">
		   <img title="<?php echo htmlspecialchars($row['store_name']); ?>" id='topStores' src='uploads/store/logos/<?php echo htmlspecialchars($row['store_logo']); ?>' alt='Store Logo' onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo htmlspecialchars($row['creator_un']); ?>'" style='width:150px; height:150px; cursor:pointer; border-radius:50%'><br>
		   <label class="w3-text-blue-grey w3-center" style="cursor:pointer;" title="<?php echo htmlspecialchars($row['store_name']); ?>" onclick="window.location.href='vendor_store.php?clickedvnd=<?php echo htmlspecialchars($row['creator_un']); ?>'"><?php echo htmlspecialchars($row['store_name']); ?></label>
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
         $range = 5; // Adjust this value for more or fewer surrounding pages
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
  </div>
  </div>
        </div>
    </div>
</div>
<?php } ?>
<button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-arrow-up" style="border-radius: 50%"></button>
<?php
    include 'includes/footer.php';
?>
</body>
</html>