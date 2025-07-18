<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'crdb');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'];
    $rating = $data['rating'];

    // Insert rating into the database
    $stmt = $conn->prepare("INSERT INTO product_ratings (product_id, rating) VALUES (?, ?)");
    $stmt->bind_param('ii', $productId, $rating);
    $stmt->execute();
    $stmt->close();

    // Calculate new average rating
    $result = $conn->query("SELECT AVG(rating) AS averageRating FROM product_ratings WHERE product_id = $productId");
    $averageRating = $result->fetch_assoc()['averageRating'];

    echo json_encode(['success' => true, 'averageRating' => $averageRating]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>