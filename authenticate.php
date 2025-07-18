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

// Handle product upload
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
if (isset($_POST['subitmbtn'])){
    $sort_prod = strtoupper(htmlspecialchars($_POST['sort_prod']));
    $itemname = strtoupper(htmlspecialchars($_POST['itemname']));
    $itemid = strtoupper(htmlspecialchars($_POST['itemid']));
	$missdate = $_POST['missdate'];
	$owners = strtoupper(htmlspecialchars($_POST['owners']));
    $lastloc = htmlspecialchars($_POST['lastloc']);
    $des_item = htmlspecialchars($_POST['des_item']);
    $uploadDir = 'uploads/missing_items/';

    // Check for duplicate product name under the same vendor
    $checkQuery = "SELECT id FROM authitem WHERE unique_id='$itemid'";
    $checkResult = mysqli_query($DBconn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        $errorMessage = "Item Already Reported As Missing/Stolen.";
    } else {
        $imageCount = count($_FILES['item_images']['name']);
        if ($imageCount > 5) {
            $errorMessage = "You can upload a maximum of 5 images.";
        } else {
            $uploadedFiles = [];
            for ($i = 0; $i < $imageCount; $i++) {
                $fileTmpPath = $_FILES['item_images']['tmp_name'][$i];
                $fileName = $_FILES['item_images']['name'][$i];
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $fileSize = $_FILES['item_images']['size'][$i];

                if (in_array(strtolower($fileExtension), $allowedExtensions) && $fileSize <= 2 * 1024 * 1024) {
                    $newFileName = uniqid('reported_') . '.' . $fileExtension;
                    $destination = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        $uploadedFiles[] = $newFileName;
                    }
                }
            }

            if (count($uploadedFiles) > 0) {
                $imagesJson = json_encode($uploadedFiles);
                $query = "INSERT INTO authitem (item_type, item_name, unique_id, sm_date, owners_name, last_loc, description, item_image) 
                          VALUES ('$sort_prod', '$itemname', '$itemid', '$missdate', '$owners', '$lastloc', '$des_item', '$imagesJson')";
                if (mysqli_query($DBconn, $query)) {
                    $successMessage = "Item reported successfully.";
                } else {
                    $errorMessage = "Failed to save item to the database.";
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
<!-- <script src="includes/sessionTimeout.js"></script> -->
<style>
        .preview-img {
            max-width: 300px;
            display: none;
        }
		
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}

</style>
<body class="w3-theme-l5">

<?php
  include 'includes/pubnav.php';
  ?>
  <br><br><br>
<!-- Page Container -->
<div class="w3-display-container w3-content" style="max-width:1600px; margin-top:30px">

    <div class="w3-row-padding">
      <div class="w3-col m6">
        <div class="w3-card w3-round w3-white">
          <div class="w3-container">
            <h2 class="w3-center">REPORT STOLEN OR MISSING ITEMS</h2>
            <p class="w3-justify">
			<fieldset>
				<legend></legend>
				<form method="POST" action="" enctype="multipart/form-data">
				<label for="sort_prod" style="font-size:20px">Select Stolen/Missing Item Type</label>
				<select class="w3-text-blue" name="sort_prod" style="width:90%" required>
					<option value="">--Select Item--</option>
					<option value="Automobiles">Automobiles</option>
					<option value="Credentials">Credentials</option>
					<option value="Electronics">Electronics</option>
					<option value="Mobile Devices">Mobile Devices</option>
					<option value="Other Items">Other Items</option>
					<option value="Travel Documents">Travel Documents</option>
				</select><br><br>
				
				<label for="itemname" style="font-size:20px">Enter Stolen/Missing Item Name</label><br>
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="itemname" style="width:90%" placeholder="ITEM NAME" required><br><br>
				
				<label for="itemid" style="font-size:20px">Enter Stolen/Missing Item Unique ID</label><br>
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="itemid" style="width:90%" placeholder="IMEI/VIN/CHASIS/SERIAL/PASSPORT/DOCUMENT NUMBER" required><br><br>
				
				<label for="missdate" style="font-size:20px">Select Stolen/Missing Item Date</label><br>
				<input class="w3-twothird w3-padding w3-round-large" type="date" name="missdate" style="width:90%" placeholder="Search by products name" required><br><br>
				
				<label for="owners" style="font-size:20px">Owners Name</label><br>
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="owners" style="width:90%" placeholder="OWNERS NAME" required><br><br>
				
				<label for="lastloc" style="font-size:20px">Last Known Location</label><br>
				<input class="w3-twothird w3-padding w3-round-large" type="text" name="lastloc" style="width:90%" placeholder="LAST KNOWN LOCATION" required><br><br>
				
				<label for="des_item" style="font-size:20px">Describe Item</label><br>
				<textarea name="des_item" style="width:90%" required></textarea><br><br>

				<label for="item_images" style="font-size:20px">Item Images <small><i>(max 5)</i></small>:</label><br>
				<input type="file" name="item_images[]" style="width:90%" accept="image/*" multiple required 
					   onchange="previewImages(event)">
				<div id="image-preview"></div><br>
				<button class="w3-padding w3-round-large w3-green" name="subitmbtn" id="subitmbtn" type="submit"><i class="fa fa-search"></i> Submit</button>
				</form>
			</fieldset>
            </p>
          </div>
        </div>
      </div>

      <div class="w3-col m6"><br class="w3-hide-medium w3-hide-large">
        <div class="w3-card w3-round w3-white">
          <div class="w3-container">
            <h2 class="w3-center">AUTHENTICATE ITEMS<br>
			<label class="w3-text-red"><i>Verify an item hasn't been reported as stolen/missing before purchasing it.</i></label></h2>
            <p class="w3-justify">
			<fieldset>
				<legend></legend>
				<form method="POST" action="" enctype="multipart/form-data">
				<label>Search Item</label><br>
				<input class="w3-twothird w3-padding w3-round-large" type="text" style="width:90%" name="schitem" placeholder="Enter IMEI/VIN/CHASIS/SERIAL/PASSPORT/DOCUMENT NUMBER to search" required><br><br><br>
				<button class="w3-padding w3-round-large w3-green" name="searchitmbtn" id="searchitmbtn" type="submit"><i class="fa fa-search"></i> Search</button>
				<a href="authenticate.php"><button class="w3-padding w3-round-large w3-red" name="rstsrchbtn" id="rstsrchbtn" type="button"><i class="fa fa-reset"></i> Reset</button></a>
				</form>
         <hr style="border: 1px solid">
            <h2 class="w3-center">REPORTED ITEMS</h2>

<div class="scrollable-table" style="overflow-x: auto;">
        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr>
                <th>S/N</th>
                <th>Item Image</th>
                <th>Item Name</th>
                <th>Item Unique ID</th>
            </tr>
				<?php
				$sn = 0;
				$sn++;
				if (isset($_POST['searchitmbtn'])){
    $schitm = strtoupper(htmlspecialchars($_POST['schitem']));
				$plquery = "SELECT * FROM authitem WHERE unique_id = '$schitm' OR item_name = '$schitm' ORDER BY RAND() LIMIT 5";
				$plresults = mysqli_query($DBconn, $plquery);

				if ($plresults && mysqli_num_rows($plresults) > 0) {
					while ($row = mysqli_fetch_assoc($plresults)) {
						$in = htmlspecialchars($row['item_name']);
						$ui = htmlspecialchars($row['unique_id']);
                        $images = json_decode($row['item_image'], true);
						?>
			<tr>
				<td><?php echo $sn++; ?></td>
				<td onclick='showDescription(". $ui .")'><?php echo "<img class='w3-round-large' src='uploads/missing_items/" . htmlspecialchars($images[0]) . "' alt='Item Image' style='width:100%; height:100px; cursor:pointer;'>"; ?></td>
				<td onclick='showDescription(". $ui .")' style='cursor:pointer;'><?php echo $in; ?></td>
				<td onclick='showDescription(". $ui .")' style='cursor:pointer;'><?php echo $ui; ?></td>

				<!-- Hidden Description (Toggled on Click) -->
				<div id="description-<?php echo $ui; ?>" 
					 class="description" 
					 style="display:none; margin-top:10px;">
					<p><b><u>ITEM DESCRIPTION</u></b><br><?php echo htmlspecialchars($row['description']); ?></p>
				</div>
			</tr>
					<?php
				} }
				}else{
				$plquery = "SELECT * FROM authitem ORDER BY RAND() LIMIT 5";
				$plresults = mysqli_query($DBconn, $plquery);

				if ($plresults && mysqli_num_rows($plresults) > 0) {
					while ($row = mysqli_fetch_assoc($plresults)) {
						$in = htmlspecialchars($row['item_name']);
						$ui = htmlspecialchars($row['unique_id']);
                        $images = json_decode($row['item_image'], true);
						$pd = htmlspecialchars($row['description']);
						$on = htmlspecialchars($row['owners_name']);
						$ll = htmlspecialchars($row['last_loc']);
						$sd = htmlspecialchars($row['sm_date']);
						$it = htmlspecialchars($row['item_type']);
						?>
			<tr>
				<td><?php echo $sn++; ?></td>
				<td onclick="document.getElementById('<?php echo $ui; ?>').style.display='block'"><?php echo "<img class='w3-round-large' src='uploads/missing_items/" . htmlspecialchars($images[0]) . "' alt='Item Image' style='width:100%; height:100px; cursor:pointer;'>"; ?></td>
				<td onclick="document.getElementById('<?php echo $ui; ?>').style.display='block'" style='cursor:pointer;'><?php echo $in; ?></td>
				<td onclick="document.getElementById('<?php echo $ui; ?>').style.display='block'" style='cursor:pointer;'><?php echo $ui; ?></td>
			</tr>
					<?php
				} }
				}
				?>
		</table><br>
		</div>
			</fieldset>
			</p>
          </div>
        </div>
      </div>
    </div><br class="w3-hide-small"><br><br>
</div>
<!-- End Page Container -->

<!-- View authenticate item details Modal -->
<div id="<?php echo $ui; ?>" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
      <div class="w3-container w3-white w3-center">
        <i onclick="document.getElementById('<?php echo $ui; ?>').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge" style="w3-red"> <h1><b> X </b></h1></i>
        <h2 class="w3-wide">REPORTED ITEM DETAILS</h2>
         <hr style="border: 1px solid">
		<div class="w3-row">
			<div class="w3-col m6" style="padding:10px">
				<?php echo "<img class='w3-round-large' src='uploads/missing_items/" . htmlspecialchars($images[0]) . "' alt='Item Image' style='width:100%; height:300px;'>"; ?>
			</div>
			<div class="w3-col m6" style="text-align:left; padding: 10px">
				<label><h3><b>ITEM TYPE: </b></h3> <?php echo htmlspecialchars($it); ?></label><br>
				<label><h3><b>ITEM NAME: </b></h3> <?php echo htmlspecialchars($in); ?></label><br>
				<label><h3><b>ITEM ID: </b></h3> <?php echo htmlspecialchars($ui); ?></label><br>
				<label><h3><b>OWNER'S NAME: </b></h3> <?php echo htmlspecialchars($on); ?></label><br>
				<label><h3><b>LAST KNOWN LOCATION: </b></h3> <?php echo htmlspecialchars($ll); ?></label><br>
				<label><h3><b>STOLEN/MISSING DATE: </b></h3> <?php echo htmlspecialchars($sd); ?></label><br>
				<label><h3><b>ITEM DESCRIPTION: </b></h3> <?php echo htmlspecialchars($pd); ?></label>
			</div>
		</div>
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