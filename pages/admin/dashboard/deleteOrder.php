<?php
// Include your database connection
include '../../../database/db.php';

// Make sure 'id' is provided
if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("Missing order id");
}

$order_id = intval($_GET['id']);

// Delete from order_items first (foreign key constraint)
$conn->query("DELETE FROM order_items WHERE order_id=$order_id");

// Then delete from orders table
$conn->query("DELETE FROM orders WHERE id=$order_id");

// Return success
http_response_code(200);
?>
