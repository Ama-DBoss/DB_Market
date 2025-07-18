<?php
require_once 'includes/db.con.php'; // Include your database connection
include 'includes/functions.php';
include ('server.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'myProducts') {
        $sn = 1;
		$sun = $_SESSION['username'];
		global $sun;
        echo '<h3 class="w3-center">My Products</h3>
         <hr style="border: 1px solid">
<div class="scrollable-table" style="overflow-x: auto; overflow-y: auto; height: 500px;">
        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr>
                <th>S/N</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Upload Date</th>
                <th>Action</th>
            </tr>';
			
  // Define pagination variables
  $items_per_page = 10;
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $offset = ($current_page - 1) * $items_per_page;
  $vn = $_SESSION['username'];

  // Prepare and execute the SQL query with LIMIT and OFFSET for pagination
  $stmt = $DBconn->prepare("SELECT * FROM sales WHERE product_name = ? AND vendor_uname = ? OR product_name LIKE ? AND vendor_uname LIKE ?");
  $stmt->bind_param('ssss', $psn, $vn, $psn, $vn,);
  $stmt->execute();
  $result = $stmt->get_result();

  // Count total songs to calculate total pages
  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE product_name = '$psn' AND vendor_uname= '$vn' OR product_name LIKE '$psn' AND vendor_uname= '$vn'");
  $total_items = $count_result->fetch_assoc()['total'];
  $total_pages = ceil($total_items / $items_per_page);

  $stmt->close();
  
		global $current_page;
		global $total_pages;

        $myspquery = "SELECT vendor_id FROM connect_users WHERE uname='$sun'";
        $results = mysqli_query($DBconn, $myspquery);

        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $venid = $row['vendor_id'];
			}
		}

        $mypquery = "SELECT * FROM sales WHERE vendor_id='$venid' LIMIT 10";
        $results = mysqli_query($DBconn, $mypquery);

        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $images = json_decode($row['product_image'], true);
                $image = htmlspecialchars($images[0] ?? 'no-image.jpg');
                echo '
					<tr>
                    <td>' . $sn++ . '</td>
                    <td><img src="uploads/products/' . $image . '" alt="Product Image" style="width:50px; height:50px;"></td>
                    <td>
					<form action="product_view.php" method="GET" enctype="multipart/form-data">
						<p>
                        <input style="cursor:pointer; border:none" type="submit" name="clickedad" id="clickedad" class="w3-text-blue" value="'. htmlspecialchars($row['product_name']).'">
						</p>
                      </form></td>
                    <td>₦' . number_format(htmlspecialchars($row['product_price']), 2) . '</td>
                    <td>' . htmlspecialchars($row['stock_quantity']) . '</td>
                    <td>' . htmlspecialchars($row['created_at']) . '</td>
                    <td><button class="w3-button w3-red w3-round" onclick="deleteProduct(' . $row['id'] . ')">Delete</button></td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="7">No products found.</td></tr>';
        }

  // Count total songs to calculate total pages
//  $count_result = $DBconn->query("SELECT COUNT(*) AS total FROM sales WHERE vendor_uname='$sun' OR vendor_id='$sun'");
//  $total_items = $count_result->fetch_assoc()['total'];
//  $total_pages = ceil($total_items / $items_per_page);
  
		global $current_page;
		global $total_pages;
        echo '</table>
			</div>';
    } elseif ($action === 'myWishlist') {
        $sn = 1;
        echo '<h3 class="w3-center">My Wishlist</h3>
         <hr style="border: 1px solid">
<div class="scrollable-table" style="overflow-x: auto; overflow-y: auto; height: 500px;">
        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr class="">
                <th>S/N</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>';
		$sun = $_SESSION['username'];

        $myspquery = "SELECT vendor_id FROM connect_users WHERE uname='$sun'";
        $results = mysqli_query($DBconn, $myspquery);

        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $venids = $row['vendor_id'];
			}
		}

        $mypquery = "SELECT * FROM wishlist WHERE user_id='$venids' ORDER BY id DESC";
        $results = mysqli_query($DBconn, $mypquery);

        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                $images = json_decode($row['product_image'], true);
                $image = htmlspecialchars($images[0] ?? 'no-image.jpg');
                echo '<tr>
                    <td>' . $sn++ . '</td>
                    <td><img src="uploads/products/' . $image . '" alt="Product Image" style="width:50px; height:50px;"></td>
                    <td>
					<form action="product_view.php" method="GET" enctype="multipart/form-data">
						<p>
                        <input style="cursor:pointer; border:none" type="submit" name="clickedad" id="clickedad" class="w3-text-blue" value="'. htmlspecialchars($row['product_name']).'">
						</p>
                      </form></td>
                    <td>₦' . number_format(htmlspecialchars($row['product_price']), 2) . '</td>
                    <td><button class="w3-button w3-red w3-round" onclick="removeProduct(' . $row['id'] . ')">Remove</button></td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="5">No Wishlist items found.</td></tr>';
        }
        echo '</table>
			</div>';
    } elseif ($action === 'settings') {
		$su = $_SESSION['username'];
        $setquery = "SELECT * FROM store WHERE creator_un ='$su' LIMIT 1";
        $setresults = mysqli_query($DBconn, $setquery);

        if (mysqli_num_rows($setresults) > 0) {
            while ($row = mysqli_fetch_assoc($setresults)) {
        echo '<h3 class="w3-center">Store Settings</h3>
         <hr style="border: 1px solid">
			
			<div class="">
    <form action="" method="POST" enctype="multipart/form-data">
    <label class="w3-hide" for="owners_name" style="font-size:20px">Creators Username:</label>
	<input class="w3-hide" type="text" name="owners_name" value="'. htmlspecialchars($row['creator_un']).'" style="width:90%" readonly required>
	
    <label for="store_name" style="font-size:20px">Store Name:</label><br>
    <input type="text" name="store_name" style="width:90%" placeholder="Store Name" value="'. htmlspecialchars($row['store_name']).'" required><br><br>

    <label for="store_contact" style="font-size:20px">Contact Number:</label><br>
    <input type="text" name="store_contact" style="width:90%" placeholder="Store Number" value="'. htmlspecialchars($row['store_number']).'" required><br><br>

    <label for="store_whatsapp" style="font-size:20px">WhatsApp Number:</label><br>
    <input type="text" name="store_whatsapp" style="width:90%" placeholder="Store WhatsApp Number" value="'. htmlspecialchars($row['store_whatsapp']).'" required><br><br>

    <label for="store_location" style="font-size:20px">Store Location:</label><br>
    <input type="text" name="store_location" style="width:90%" placeholder="Store Location" value="'. htmlspecialchars($row['store_location']).'" required><br><br>

    <label for="store_description" style="font-size:20px">Store Description:</label><br>
    <input type="text" name="store_description" style="width:90%" placeholder="Store Description" value="'. htmlspecialchars($row['store_desc']).'" required><br><br>

    <label for="store_facebook" style="font-size:20px">Facebook Handle <small><i>(optional)</i></small>:</label><br>
    <input type="text" name="store_facebook" style="width:90%" placeholder="Facebook Handle" value="'. htmlspecialchars($row['store_fb']).'"><br><br>

    <label for="store_instagram" style="font-size:20px">Instagram Handle <small><i>(optional)</i></small>:</label><br>
    <input type="text" name="store_instagram" style="width:90%" placeholder="Instagram Handle" value="'. htmlspecialchars($row['store_ig']).'"><br><br>

    <label for="store_snapchat" style="font-size:20px">SnapChat Handle <small><i>(optional)</i></small>:</label><br>
    <input type="text" name="store_snapchat" style="width:90%" placeholder="SnapChat Handle" value="'. htmlspecialchars($row['store_sc']).'"><br><br>

    <label for="store_tiktok" style="font-size:20px">TikTok Handle <small><i>(optional)</i></small>:</label><br>
    <input type="text" name="store_tiktok" style="width:90%" placeholder="TikTok Handle" value="'. htmlspecialchars($row['store_tk']).'"><br><br>

    <label for="store_youtube" style="font-size:20px">YouTube Handle <small><i>(optional)</i></small>:</label><br>
    <input type="text" name="store_youtube" style="width:90%" placeholder="YouTube Handle" value="'. htmlspecialchars($row['store_yt']).'"><br><br>

    <label for="banner_image" style="font-size:20px">Banner Image:</label><br>
	<img src="uploads/store/banners/'. htmlspecialchars($row['store_banner']).'" alt="Store Banner Image" width="200"><br><br>
    <input type="file" name="banner_image" style="width:90%" accept="image/*" 
           onchange="previewImages(event)"><br><br>

    <label for="store_logo" style="font-size:20px">Store Logo:</label><br>
	<img src="uploads/store/logos/'. htmlspecialchars($row['store_logo']).'" alt="Store Logo Image" width="200"><br><br>
    <input type="file" name="store_logo" style="width:90%" accept="image/*" 
           onchange="previewImages(event)"><br><br>

    <button type="submit" class="w3-green w3-large w3-round-large"><i class="fa fa-upload"></i> Update Store Details</button>
	</form>
</div>';
		} }
    } elseif ($action === 'promote') {
        echo '<h3 class="w3-center">Promote Store</h3>
		<h5 class="w3-center w3-text-green"><i>be among the top rated and displayed stores for more visibility by users.</i></h5>
         <hr style="border: 1px solid">
			
			<div class="">
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'twodaysPromotion\' src=\'images/promo_card/twodays.png\' alt=\'Two Days Promotion\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>Two Days Promotion</b></h3>
					<h4>₦2,000:00</h4>
					<hr style="border: 1px solid">
					<h4><b>Benefits</b></h4>
					<ul style="list-type:none">
						<li>aaa</li>
						<li>bbb</li>
						<li>ccc</li>
					</ul>
					<button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Purchase</button>
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'oneWeekPromotion\' src=\'images/promo_card/oneweek.png\' alt=\'One Week Promotion\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>One Week Promotion</b></h3>
					<h4>₦6,000:00</h4>
					<hr style="border: 1px solid">
					<h4><b>Benefits</b></h4>
					<ul style="list-type:none">
						<li>aaa</li>
						<li>bbb</li>
						<li>ccc</li>
					</ul>
					<button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Purchase</button>
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'onemonthPromotion\' src=\'images/promo_card/onemonth.png\' alt=\'One Month Promotion\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>One Month Promotion</b></h3>
					<h4>₦25,000:00</h4>
					<hr style="border: 1px solid">
					<h4><b>Benefits</b></h4>
					<ul style="list-type:none">
						<li>aaa</li>
						<li>bbb</li>
						<li>ccc</li>
					</ul>
					<button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Purchase</button>
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'threeMonthPromotion\' src=\'images/promo_card/threemonths.png\' alt=\'Three Months Promotion\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>Three Months Promotion</b></h3>
					<h4>₦70,000:00</h4>
					<hr style="border: 1px solid">
					<h4><b>Benefits</b></h4>
					<ul style="list-type:none">
						<li>aaa</li>
						<li>bbb</li>
						<li>ccc</li>
					</ul>
					<button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Purchase</button>
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'sixMonthPromotion\' src=\'images/promo_card/sixmonths.png\' alt=\'Six Months Promotion\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>Six Months Promotion</b></h3>
					<h4>₦130,000:00</h4>
					<hr style="border: 1px solid">
					<h4><b>Benefits</b></h4>
					<ul style="list-type:none">
						<li>aaa</li>
						<li>bbb</li>
						<li>ccc</li>
					</ul>
					<button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Purchase</button>
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'oneYearPromotion\' src=\'images/promo_card/oneyear.png\' alt=\'One Year Promotion\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>One Year Promotion</b></h3>
					<h4>₦250,000:00</h4>
					<hr style="border: 1px solid">
					<h4><b>Benefits</b></h4>
					<ul style="list-type:none">
						<li>aaa</li>
						<li>bbb</li>
						<li>ccc</li>
					</ul>
					<button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Purchase</button>
				</div>
			</div>
			</div>';
    } elseif ($action === 'ads') {
        echo '<h3 class="w3-center">Create Product Ads</h3>
		<h5 class="w3-center w3-text-green"><i>advertise your products to reach more audience and get more engagements.</i></h5>
         <hr style="border: 1px solid">
			
			<div class="">
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'twodaysAds\' src=\'images/promo_card/twodays.png\' alt=\'Two Days Ads\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>Two Days Ads - ₦2,000:00</b>
					<span class="w3-right"><button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Select</button></span>
					</h3>
					<hr style="border: 1px solid">
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'oneWeekAds\' src=\'images/promo_card/oneweek.png\' alt=\'One Week Ads\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>One Week Ads - ₦6,000:00</b>
					<span class="w3-right"><button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Select</button></span>
					</h3>
					<hr style="border: 1px solid">
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'onemonthAds\' src=\'images/promo_card/onemonth.png\' alt=\'One Month Ads\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>One Month Ads - ₦25,000:00</b>
					<span class="w3-right"><button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Select</button></span>
					</h3>
					<hr style="border: 1px solid">
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'threeMonthAds\' src=\'images/promo_card/threemonths.png\' alt=\'Three Months Ads\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>Three Months Ads - ₦70,000:00</b>
					<span class="w3-right"><button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Select</button></span>
					</h3>
					<hr style="border: 1px solid">
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'sixMonthAds\' src=\'images/promo_card/sixmonths.png\' alt=\'Six Months Promotion\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>Six Months Ads - ₦130,000:00</b>
					<span class="w3-right"><button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Select</button></span>
					</h3>
					<hr style="border: 1px solid">
				</div>
			</div>
			
            <div class="w3-third w3-padding w3-margin-bottom">
                <div class="w3-card w3-padding w3-white">
                    <div class="products">
                       <img id=\'oneYearAds\' src=\'images/promo_card/oneyear.png\' alt=\'One Year Ads\' style=\'width:100%; height:200px; cursor:pointer;\'>
					</div>
					<h3><b>One Year Ads - ₦250,000:00</b>
					<span class="w3-right"><button type="submit" class="w3-blue w3-large w3-round-large"><i class="fa fa-money-bill"></i> Select</button></span>
					</h3>
					<hr style="border: 1px solid">
				</div>
			</div>
			</div>';
    } elseif ($action === 'delStore') {
        echo '<h3 class="w3-center">Delete Store!!!</h3>
		<h5 class="w3-center w3-text-green"><i>You will loose all history and records of your store activities.<br>This action cannot be undone.</i></h5>
         <hr style="border: 1px solid">
		<div class="w3-center ">
			<button name="delstore" id="delstore" type="submit" class="w3-red w3-large w3-round-large"><i class="fa fa-recycle"></i> Delete Store Details ?</button>
		</div>';
		
		if (isset($_POST['delstore'])){
			$cun = $_SESSION['username'];
			$stn = $storename;
			
        $deleteStoreSql = "DELETE FROM store WHERE creator_un = ? AND store_name = ?";

        $stmt = mysqli_prepare($DBconn, $deleteStoreSql);
        mysqli_stmt_bind_param($stmt, 'ss', $cun, $stn);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
		}
    }
    } else {
        echo '<p>Invalid action.</p>';
    }
}
?>
