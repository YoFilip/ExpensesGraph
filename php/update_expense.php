<?php
// Start the session
session_start();

// Include database connection details
require_once "connect.php";

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in'])) {
    header('Location: ../sites/login_page.php');
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $id = $_POST['id'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $category_id = $_POST['category'];

    // Create a new database connection
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    // Check for database connection errors
    if ($connection->connect_errno != 0) {
        echo "Error: " . $connection->connect_errno;
        exit();
    }

    // Prepare and execute the SQL query to update the expenses record
    $sql = "UPDATE expenses SET date = '$date', description = '$description', amount = $amount, expense_id = $category_id WHERE id = $id";
    
    if ($connection->query($sql)) {
        // Redirect to the reports page on successful update
        header('Location: ../sites/raports_page.php');
    } else {
        // Display an error message if the update fails
        echo "Error updating record: " . $connection->error;
    }

    // Close the database connection
    $connection->close();
}
?>
