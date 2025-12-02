<?php
include '../../../database/db.php'; // Adjust path if needed

// 1. Check if ID is provided
if (!isset($_GET['id'])) {
    die("Food item ID not specified.");
}

$id = intval($_GET['id']); // Always sanitize

// 2. Fetch the current food item
$result = $conn->query("SELECT * FROM food_items WHERE id = $id");
if ($result->num_rows == 0) {
    die("Food item not found.");
}

$item = $result->fetch_assoc();

// 3. Handle form submission
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // 3a. Check for duplicate name in other records
    $check = $conn->query("SELECT id FROM food_items WHERE name='$name' AND id != $id");
    if ($check->num_rows > 0) {
        $error = "A food item with this name already exists. Please choose a different name.";
    } else {
        // 3b. Update the food item
        $sql = "UPDATE food_items 
                SET name='$name', price='$price', description='$description'
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            header("Location: food_dashboard.php");
            exit;
        } else {
            $error = "Error updating food item: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Food Item</title>
</head>

<body>

    <h2>Edit Food Item</h2>

    <!-- Display error message if duplicate or update fails -->
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">

        Name: <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required><br><br>

        Price: <input type="number" name="price" step="0.01" value="<?= $item['price'] ?>" required><br><br>

        Description: <textarea name="description"><?= htmlspecialchars($item['description']) ?></textarea><br><br>

        <button name="update">Update</button>
    </form>

    <br>
    <a href="food_dashboard.php">Back to Food Dashboard</a>

</body>

</html>