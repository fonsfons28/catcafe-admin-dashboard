<?php
include '../../../database/db.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("Missing order id");
}

$order_id = intval($_GET['id']);

// Update the order's status to finished
$conn->query("UPDATE orders SET status='finished' WHERE id=$order_id");

http_response_code(200);
?>
