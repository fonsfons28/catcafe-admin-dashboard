<?php
include '../../../database/db.php'; // Adjust path if needed

$error = ''; // to store error messages

// If the "Submit" button was clicked
if (isset($_POST['submit'])) {

    // Get input values (using real_escape_string to allow # and ')
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    // Check if a food item with the same name already exists
    $check = $conn->query("SELECT id FROM food_items WHERE name='$name'");
    if ($check->num_rows > 0) {
        $error = "A food item with this name already exists.";
    } else {
        // Insert into food_items table
        $sql = "INSERT INTO food_items (name, description, price) VALUES ('$name', '$description', '$price')";
        
        // Redirect back to food_dashboard once finished
        if ($conn->query($sql)) {
            header("Location: food_dashboard.php"); 
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Food Item</title>
</head>

<body>

    <h2>Add New Food Item</h2>

    <!-- Display error if exists -->
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">

        <!-- Name -->
        Name: <input type="text" name="name" required><br><br>

        <!-- Price -->
        Price: <input type="number" name="price" step="0.01" required><br><br>

        <!-- Description -->
        Description: <textarea name="description"></textarea><br><br>

        <button name="submit">Save</button>
    </form>

    <br>
    <a href="food_dashboard.php">Back to Food Dashboard</a>

</body>

</html>
