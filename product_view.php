<?php
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
<script src="js/new_myjs.js" defer></script>
<style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
</style>

<body class="w3-theme-l5">
    
    <!-- Navigation Bar -->
	<?php if(isset($_SESSION['username'])) : ?>
		<?php include_once "includes/nav.php"; ?>
	<?php else : ?>
		<?php include_once "includes/pubnav.php"; ?>
	<?php endif ?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1600px;margin-top:10px"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">
    <!-- The Grid -->
    <div class="w3-row">
      <div class="w3-col m12">
  <!-- package Section -->
<div class="w3-container" style="padding:10px 10px">
    <h2 class="w3-wide w3-center">PRODUCT DETAILS</h2>
    <p class="w3-large">
	<h1 class="w3-text-red">
	<?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>
         <hr class="" style="border: 1px solid">
		 
        <?php
        if (isset($_GET['clickedad'])) {
            $clickedlast = mysqli_real_escape_string($DBconn, $_GET['clickedad']);
     
            $sql = "SELECT * FROM sales WHERE product_name='$clickedlast' LIMIT 1";
            $result = $DBconn->query($sql);
				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						$pc = htmlspecialchars($row['category_name']); ?>
					
                    <div class="product">
                    <!-- Display Product Images -->
                    <div class="w3-third" style="padding:10px 10px">
                        <?php 
                        // Decode and display images
                        $images = json_decode($row['product_image'], true);
                        if (!empty($images)) {
                            echo "<div class='post-images'>";
                            
                            // Display the first image as the parent image
                            echo "<div class='parent-image'>";
                            echo "<img class='w3-round-large' id='parentImage' src='uploads/products/" . htmlspecialchars($images[0]) . "' alt='Parent Image' style='width:100%; height:auto;'>";
                            echo "</div>";
                            
                            // Display the other images as thumbnails
                            echo "<div class='child-images'>";
                            foreach ($images as $index => $image) {
                                if ($index >= 0) {
                                    echo "<img class='thumbnail w3-round-large' src='uploads/products/" . htmlspecialchars($image) . "' alt='Thumbnail' 
                                            style='width:50px; height:auto; margin-right:10px; cursor:pointer;' 
                                            onclick='changeParentImage(this)'>";
                                }
                            }
                            echo "</div>";

                            echo "</div>";
                        }
                        ?>
<!-- JavaScript for handling image click and switch -->
<script>
    function changeParentImage(clickedImage) {
        // Get the src of the clicked thumbnail
        var newSrc = clickedImage.src;
        
        // Set the new image as the parent image
        document.getElementById('parentImage').src = newSrc;
    }
</script>

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
                    </div>

                        <!-- Product Details -->
                        <div class="" style="padding:10px 10px">
                        <h5 class="w3-text-blue"><?php echo htmlspecialchars(strtoupper($row['product_name'])); ?></h5>
                        <p class="w3-text-blue-grey"><b>Price:</b> ₦<?php echo number_format(htmlspecialchars($row['product_price']),2); ?></p>
                        <p class="w3-text-blue-grey"><b>Condition:</b> <?php echo $row['product_condition']; ?></p>
                        <p class="w3-text-blue-grey"><small><b>Tags:</b> <i><?php echo htmlspecialchars($row['product_tags']); ?></i></small></p>
                        <p class="w3-text-blue-grey"><small><b>SKU:</b> <i><?php echo htmlspecialchars($row['product_sku']); ?></i></small></p>
<form action="vendor_store.php" method="GET" enctype="multipart/form-data">
                        <p class="w3-text-blue-grey"><b>Vendor Name / ID No:</b><small><i> <input style="cursor:pointer; border:none; background-color:" type="submit" name="clickedvnd" id="clickedvnd" class="w3-text-blue-grey" value="<?php echo htmlspecialchars($row['vendor_uname']); ?>"> / <?php echo htmlspecialchars($row['vendor_id']); ?></i></small></p>
						</form>

                        <!-- Action Buttons -->
                        <div class="w3-margin-top">
                            <!-- WhatsApp Button with Pre-filled Message -->
                            <a href="https://wa.me/<?php echo htmlspecialchars($row['vendor_pno'])?>?text=<?php echo urlencode(
                                'Hello, I am interested in the following product: ' . 
                                "\nProduct Name: " . htmlspecialchars($row['product_name']) . 
                                "\nPrice: ₦" . htmlspecialchars($row['product_price']) . 
                                "\nSKU: " . htmlspecialchars($row['product_sku']) . 
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
 			<!-- Product Description -->
			<div style="padding:10px 10px">
			<fieldset>
				<legend style="font-size:20px; padding:10px 10px;"><b><u>PRODUCT DESCRIPTION</u></b></legend>
			<div id="" class="description" style="margin-top:10px;">
				<p><?php echo htmlspecialchars($row['product_description']); ?></p>
			</div>
			</fieldset>
			</div>
			
<!-- Product Ratings -->
<div style="padding:10px 10px;">
    <fieldset>
        <legend style="font-size:20px; padding:10px 10px;"><b><u>RATINGS</u></b></legend>
        <?php if (!isset($_SESSION['username'])) {
            echo '
        <button onclick="window.location.href=\'login.php\'" title="Login To Rate" class="w3-button w3-round-large w3-purple w3-ripple">
            <i class="fa fa-star" style="padding-right: 5px;"></i>Login To Rate
        </button>';
        } else {
            echo '
        <div id="rating-container" style="margin-top:10px;">
            <!-- Stars with Numbers in Different Rows -->
            <div style="margin-bottom: 10px;">
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="4.5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="4.5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="5"></i><br>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="3.5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="3.5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="4"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="4"></i><br>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="2.5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="3"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="3"></i><br>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="1.5"></i>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="2"></i><br>
                <i class="fa fa-star-o" style="color: gold; font-size: 20px;" data-value="1"></i>
            </div>
        </div>';
        }
        ?>

        <p id="highest-rating" style="margin-top: 20px; font-size: 18px; color: #333;">
            Rating: 0 <i class="fa fa-star" style="color: gold; font-size: 20px;"></i>
        </p>
        <p id="product1-average-rating" style="margin-top: 20px; font-size: 18px; color: #333;">
            Average Rating: 0 <i class="fa fa-star" style="color: gold; font-size: 20px;"></i>
        </p>

        <style>
            .rating {
                display: inline-block;
                font-size: 24px;
                color: #ccc;
                cursor: pointer;
            }

            .rating span {
                margin: 0 5px;
                transition: color 0.3s;
            }

            .rating span:hover,
            .rating span:hover ~ span {
                color: #f5b301; /* Highlight color */
            }

            .rating span.selected,
            .rating span.selected ~ span {
                color: #f5b301; /* Selected stars color */
            }
        </style>

    </fieldset>
</div>

    </fieldset>
</div>

	<!-- Product Comment Section -->
	<div style="padding:10px 10px">
		<fieldset>
        <legend style="font-size:20px; padding:10px 10px;"><b><u>COMMENTS SECTION</u></b></legend>
		<form method="POST" action="">
			<textarea style="width:100%" name="pcom" placeholder="comments..." required></textarea><br><br>
			<input type="submit" name="subcom" value="Comment">
			<input class="w3-hide" type="text" name="pid" value="<?php echo htmlspecialchars($row['product_sku']); ?>">
			<input class="w3-hide" type="text" name="pname" value="<?php echo htmlspecialchars($row['product_name']); ?>">
		</form>
		
		<?php
		
		$cpid = htmlspecialchars($row['product_sku']);
		$cpname = htmlspecialchars($row['product_name']);

        $cquery = "SELECT * FROM procom WHERE p_sku = '$cpid' AND p_name = '$cpname' ORDER BY p_comdate DESC LIMIT 5";
        $results = mysqli_query($DBconn, $cquery);

        if (mysqli_num_rows($results) > 0) { ?>
    <hr style="border: 1px solid">
            <?php while ($row = mysqli_fetch_assoc($results)) {
				if(!empty($row['com_pp'])) {
					$cpp = htmlspecialchars($row['com_pp']);
				} else {
					$cpp = "images/avatar2.png";
					}
                echo '
					<img src="'.$cpp. '" alt="User Image" style="width:50px; height:50px;">
                    <p>'. htmlspecialchars($row['p_comdate']) .'<br><a href="profile.php?clickedac='. htmlspecialchars($row['p_comby']) .'" style="text-decoration:none">'. htmlspecialchars($row['p_comby']) .':</a> '. htmlspecialchars($row['pro_com']) .'</p>';
			}
		}
		?>
		</fieldset>
	</div>
	<?php
	
if (isset($_POST['subcom'])) {
		$subu = $_SESSION['username'];
  $pid = mysqli_real_escape_string($DBconn, $_POST['pid']);
  $pname = mysqli_real_escape_string($DBconn, $_POST['pname']);
  $pcom = mysqli_real_escape_string($DBconn, $_POST['pcom']);
  $comid = rand(100,999);
  
		$ppquery = "SELECT user_pp FROM connect_users WHERE uname = '$subu' ";
        $results = mysqli_query($DBconn, $ppquery);

        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $image = htmlspecialchars($row['user_pp']);
			}
		}
	if(!isset($_SESSION['username'])){
		$subu = "Anonymous";
		$image = "";
	}

	  $query = "INSERT INTO procom (comid, pro_com, p_sku, p_name, p_comby, com_pp) VALUES('$comid', '$pcom', '$pid', '$pname', '$subu', '$image')";
		mysqli_query($DBconn, $query);
}
function trimText($text, $maxLength = 50, $suffix = '...') {
    if (mb_strlen($text) > $maxLength) {
        return mb_strimwidth($text, 0, $maxLength, $suffix);
    }
    return $text;
}
?>

		<div class="w3-container" style="padding:10px 10px">
		<h3 class="w3-text-green w3-center">
			<?php 
			if (!empty($row['vendor_uname'])) {
				echo '
		<strong>
			OTHER PRODUCTS FROM '. htmlspecialchars(strtoupper($row['vendor_uname']))
			.'<span class="w3-right w3-text-green w3-opacity">
				<a href="vendor_store.php?clickedvnd='.htmlspecialchars($row['vendor_uname'] ?? '').'">
					VIEW MORE
				</a>
			</span>
		</strong>';
			}
			?> 
	</h3>

    <div class="w3-row-padding w3-margin-top">
            <?php
		if(!empty($row['vendor_uname'])) { $pu = $row['vendor_uname']; } else { $pu = ''; }
		} } }


// Search and Filter Logic
$searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : '';
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000000;

// Build query dynamically
$query = "SELECT sales.*, categories.category_name FROM sales 
          JOIN categories ON sales.category_id = categories.id WHERE 1=1 AND sales.product_name != '$clickedlast' AND sales.vendor_uname = '$pu' ";

if (!empty($searchQuery)) {
    $query .= " AND (sales.product_name LIKE '%$searchQuery%' OR sales.product_description LIKE '%$searchQuery%')";
}
if (!empty($categoryFilter)) {
    $query .= " AND sales.category_id = $categoryFilter";
}
if ($minPrice > 0 || $maxPrice < 10000000) {
    $query .= " AND sales.product_price BETWEEN $minPrice AND $maxPrice";
}

$query .= " ORDER BY RAND() DESC LIMIT 4";
$result = mysqli_query($DBconn, $query);

while ($row = mysqli_fetch_assoc($result)):
?>
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
                            echo "<img id='parentImage' class='w3-round-large' src='uploads/products/" . htmlspecialchars($images[0]) . "' alt='Parent Image' onclick='showDescription(". $row['id'] .")' style='width:100%; height:200px; cursor:pointer;'>";
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
                             class="descriptions" 
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
                                "\nSKU: " . htmlspecialchars($row['product_sku']) . 
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
					</div>

						<div class="w3-container" style="padding:10px 10px">
						<h3 class="w3-text-purple w3-center"><strong>MORE PRODUCTS <span class="w3-right w3-text-purple w3-opacity"><a href="product-list.php">VIEW MORE</a></span></strong></h3>
    <div class="w3-row-padding w3-margin-top">
            <?php
			
// Search and Filter Logic
$searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : '';
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000000;

// Build query dynamically
$query = "SELECT sales.*, categories.category_name FROM sales 
          JOIN categories ON sales.category_id = categories.id WHERE 1=1 AND sales.product_name != '$clickedlast' AND sales.vendor_uname != '$pu' ";

if (!empty($searchQuery)) {
    $query .= " AND (sales.product_name LIKE '%$searchQuery%' OR sales.product_description LIKE '%$searchQuery%')";
}
if (!empty($categoryFilter)) {
    $query .= " AND sales.category_id = $categoryFilter";
}
if ($minPrice > 0 || $maxPrice < 10000000) {
    $query .= " AND sales.product_price BETWEEN $minPrice AND $maxPrice";
}

$query .= " ORDER BY RAND() DESC LIMIT 8";
$result = mysqli_query($DBconn, $query);

while ($row = mysqli_fetch_assoc($result)):
?>
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
                            echo "<img id='parentImage' class='w3-round-large' src='uploads/products/" . htmlspecialchars($images[0]) . "' alt='Parent Image' onclick='showDescription(". $row['id'] .")' style='width:100%; height:200px; cursor:pointer;'>";
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
                             class="descriptions" 
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
                                "\nSKU: " . htmlspecialchars($row['product_sku']) . 
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
	<script>
		function redirectToLogin() {
			alert('Please login to save items to your wishlist.');
			window.location.href = 'login.php';
		}
	</script>

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