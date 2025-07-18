<?php
require_once 'includes/db.con.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'Login required']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    // Get the vendor ID (user ID) for the logged-in user
    $username = $_SESSION['username'];
    $vendorQuery = "SELECT vendor_id FROM connect_users WHERE uname = ?";
    $stmt = $DBconn->prepare($vendorQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $vendorResult = $stmt->get_result();

    if ($vendorResult->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit;
    }

    $vendor = $vendorResult->fetch_assoc();
    $userId = $vendor['vendor_id']; // Vendor ID is used as `user_id`

    // Check if the product already exists in the wishlist
    $checkQuery = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $DBconn->prepare($checkQuery);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Product already in wishlist']);
        exit;
    }

    // Get product details from the sales table
    $productQuery = "SELECT product_name, product_price, product_image FROM sales WHERE id = ?";
    $stmt = $DBconn->prepare($productQuery);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $productResult = $stmt->get_result();

    if ($productResult->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        exit;
    }

    $product = $productResult->fetch_assoc();
    $productName = $product['product_name'];
    $productPrice = $product['product_price'];
    $productImage = $product['product_image'];

    // Insert the product into the wishlist
    $insertQuery = "INSERT INTO wishlist (user_id, product_id, product_name, product_price, product_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $DBconn->prepare($insertQuery);
    $stmt->bind_param("iisss", $userId, $productId, $productName, $productPrice, $productImage);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product added to wishlist']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product to wishlist']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>