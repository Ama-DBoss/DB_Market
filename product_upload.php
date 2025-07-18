<?php
// Database connection
require_once 'includes/db.con.php';
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

// Fetch product categories
$categories = [];
$query = "SELECT id, category_name FROM categories ORDER BY category_name ASC"; 
$result = mysqli_query($DBconn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

// Fetch product categories
$conditions = [];
$query = "SELECT name FROM conditions ORDER BY name ASC"; 
$result = mysqli_query($DBconn, $query);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $conditions[] = $row;
    }
}

// Handle product upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sun = $_SESSION['username'];

	$myspquery = "SELECT vendor_id FROM connect_users WHERE uname='$sun'"; // Replace vendor_id=0 with the appropriate vendor session ID
	$results = mysqli_query($DBconn, $myspquery);

	if (mysqli_num_rows($results) > 0) {
		while ($row = mysqli_fetch_assoc($results)) {
			$vendorId = $row['vendor_id'];
		}
	}
    $vendorun = $_SESSION['username'];
    $productName = strtoupper(htmlspecialchars($_POST['product_name']));
    $productPrice = floatval($_POST['product_price']);
	$productquantity = intval($_POST['stock_quantity']);
	$productlocation = strtoupper(htmlspecialchars($_POST['stock_location']));
    $productDescription = htmlspecialchars($_POST['product_description']);
    $productTag = htmlspecialchars($_POST['tags']);
    $productCategory = intval($_POST['category_id']);
    $productCat = htmlspecialchars($_POST['category_name']);
    $uploadDir = 'uploads/products/';
    $vpn = htmlspecialchars($_POST['vpn']);
	$psku = 'SKU-'.rand(1000,9999);

    // Check for duplicate product name under the same vendor
    $checkQuery = "SELECT id FROM sales WHERE vendor_id='$vendorId' AND product_name='$productName'";
    $checkResult = mysqli_query($DBconn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        $errorMessage = "You already have a product with this name.";
    } else {
        $imageCount = count($_FILES['product_images']['name']);
        if ($imageCount > 5) {
            $errorMessage = "You can upload a maximum of 5 images.";
        } else {
            $uploadedFiles = [];
            for ($i = 0; $i < $imageCount; $i++) {
                $fileTmpPath = $_FILES['product_images']['tmp_name'][$i];
                $fileName = $_FILES['product_images']['name'][$i];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $fileSize = $_FILES['product_images']['size'][$i];

                if (in_array(strtolower($fileExtension), $allowedExtensions) && $fileSize <= 2 * 1024 * 1024) {
                    $newFileName = uniqid('product_') . '.' . $fileExtension;
                    $destination = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        $uploadedFiles[] = $newFileName;
                    }
                }
            }

            if (count($uploadedFiles) > 0) {
                $imagesJson = json_encode($uploadedFiles);
                $query = "INSERT INTO sales (vendor_id, vendor_uname, vendor_pno, product_name, product_sku, product_price, stock_quantity, stock_location, product_description, product_tags, product_image, category_name, category_id) 
                          VALUES ('$vendorId', '$vendorun', '$vpn', '$productName', '$psku', '$productPrice', '$productquantity', '$productlocation', '$productDescription', '$productTag', '$imagesJson', '$productCat', '$productCategory')";
                if (mysqli_query($DBconn, $query)) {
                    $successMessage = "Product uploaded successfully.";
                } else {
                    $errorMessage = "Failed to save product to the database.";
                }
            } else {
                $errorMessage = "No valid images uploaded.";
            }
        }
    }
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
<style>
        .preview-img {
            max-width: 300px;
            display: none;
        }
    </style>
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
    <h2 class="w3-wide w3-center">Upload Product</h2>
    <p class="w3-large">
	<h1 class="w3-text-red">
	<?php 
			  echo successInfo();
			  echo failureInfo();
			  include ('errors.php'); 
		?></h1></p>
         <hr style="border: 1px solid">
		 <div class="w3-half">
    <?php if (isset($errorMessage)) { echo "<p style='color: red;'>$errorMessage</p>"; } ?>
    <?php if (isset($successMessage)) { echo "<p style='color: green;'>$successMessage</p>"; } ?>
    <form action="" method="POST" enctype="multipart/form-data">
    <label for="product_name" style="font-size:20px">Product Name:</label><br>
    <input type="text" name="product_name" style="width:90%" required><br><br>

    <label for="product_price" style="font-size:20px">Product Price:</label><br>
    <input type="number" name="product_price" style="width:90%" min="0" step="1" required><br><br>

    <label for="stock_quantity" style="font-size:20px">Stock Quantity:</label><br>
    <input type="number" name="stock_quantity" style="width:90%" min="1" required><br><br>

    <label for="stock_location" style="font-size:20px">Product/Item Location:</label><br>
		<select name="stock_location" style="width:90%" required>
			<option value="">--Select Location--</option>
				<option value="Abia">Abia</option>
				<option value="Adamawa">Adamawa</option>
				<option value="Akwa-Ibom">Akwa-Ibom</option>
				<option value="Anambara">Anambara</option>
				<option value="Bauchi">Bauchi</option>
				<option value="Bayelsa">Bayelsa</option>
				<option value="Benue">Benue</option>
				<option value="Borno">Borno</option>
				<option value="Cross-Rivers">Cross-Rivers</option>
				<option value="Delta">Delta</option>
				<option value="Ebonyi">Ebonyi</option>
				<option value="Edo">Edo</option>
				<option value="Ekiti">Ekiti</option>
				<option value="Enugu">Enugu</option>
				<option value="FCT">FCT</option>
				<option value="Gombe">Gombe</option>
				<option value="Imo">Imo</option>
				<option value="Jigawa">Jigawa</option>
				<option value="Kaduna">Kaduna</option>
				<option value="Kano">Kano</option>
				<option value="Kebbi">Kebbi</option>
				<option value="Kogi">Kogi</option>
				<option value="Kwara">Kwara</option>
				<option value="Lagos">Lagos</option>
				<option value="Nasarawa">Nasarawa</option>
				<option value="Niger">Niger</option>
				<option value="Ogun">Ogun</option>
				<option value="Ondo">Ondo</option>
				<option value="Osun">Osun</option>
				<option value="Oyo">Oyo</option>
				<option value="Plateau">Plateau</option>
				<option value="Rivers">Rivers</option>
				<option value="Sokoto">Sokoto</option>
				<option value="Taraba">Taraba</option>
				<option value="Yobe">Yobe</option>
				<option value="Zamfara">Zamfara</option>
		</select><br><br>

    <label for="tags" style="font-size:20px">Tags <small><i>(comma-separated)</i></small>:</label><br>
    <input type="text" name="tags" style="width:90%" placeholder="e.g., electronics, mobile"><br><br>

    <label for="condition_name" style="font-size:20px">Product Condition:</label><br>
    <select name="condition_name" style="width:90%" required>
        <option value="">--Select Condition--</option>
        <?php foreach ($conditions as $condition): ?>
            <option value="<?php echo $condition['name']; ?>"><?php echo htmlspecialchars($condition['name']); ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="category_name" style="font-size:20px">Product Category:</label><br>
    <select name="category_name" style="width:90%" required>
        <option value="">--Select Category--</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['category_name']; ?>"><?php echo htmlspecialchars($category['category_name']); ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label class="w3-hide" for="category_id" style="font-size:20px">Category:</label><br>
    <select class="w3-hide" name="category_id" style="width:90%" required>
        <option value="">--Select Category--</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['category_name']); ?></option>
        <?php endforeach; ?>
    </select><br class="w3-hide"><br class="w3-hide">

    <label for="product_description" style="font-size:20px">Product Description:</label><br>
    <textarea name="product_description" style="width:90%" required></textarea><br><br>

    <label for="product_images" style="font-size:20px">Product Images <small><i>(max 5)</i></small>:</label><br>
    <input type="file" name="product_images[]" style="width:90%" accept="image/*" multiple required 
           onchange="previewImages(event)">
    <div id="image-preview"></div>
	
	<?php
	$gun = $_SESSION['username'];
		$sql = "SELECT * FROM connect_users WHERE uname ='$gun'";
	  $result = $DBconn->query($sql);

	  if ($result->num_rows < 0) {
	  echo "Error saving item.";
		
	  } else {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			?>
    <label class="w3-hide" for="product_name" style="font-size:20px">Vendor Phone Number:</label><br>
	  <input class="w3-hide" type="text" name="vpn" value="<?php echo $row['pnumber']; }}?>" style="width:90%" required>

    <button type="submit"><i class="fa fa-upload"></i> Upload Product</button>
</form>
</div>

<div class="w3-half w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">
	<img src="images/mountains.jpg" style="width:100%" class="w3-margin-bottom">
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