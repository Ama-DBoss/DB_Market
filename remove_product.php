<?php
require_once 'includes/db.con.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    // Check if the product exists
    $query = "SELECT * FROM wishlist WHERE id = $productId";
    $result = mysqli_query($DBconn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Delete the product from the database
        $deleteQuery = "DELETE FROM wishlist WHERE id = $productId";
        if (mysqli_query($DBconn, $deleteQuery)) {
            echo "Product removed successfully.";
        } else {
            echo "Error removing product: " . mysqli_error($DBconn);
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>