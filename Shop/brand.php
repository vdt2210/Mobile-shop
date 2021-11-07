<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['brandid'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM brand WHERE brandid = ?');
    $stmt->execute([$_GET['brandid']]);
    // Fetch the product from the database and return the result as an Array
    $brand = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$brand) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Brand does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Brand does not exist!');
}
?>