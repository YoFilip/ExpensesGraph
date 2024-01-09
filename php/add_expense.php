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

// Create a connection to the database
$connection = new mysqli($host, $db_user, $db_password, $db_name);

// Check for database connection errors
if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['id'];

// Check if the expense submission form has been submitted
if (isset($_POST['submit_expense'])) {
    // Retrieve data from the form
    $date = $_POST['date'];
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $amount = $_POST['amount'];
    $category_id = $_POST['category'];

    // Prepare and execute the SQL query using prepared statements
    $stmt = $connection->prepare("INSERT INTO expenses (user_id, date, description, amount, expense_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdsi", $user_id, $date, $description, $amount, $category_id);

    if ($stmt->execute()) {
        // Set success message in the session
        $_SESSION['expense_status'] = "success";
        $_SESSION['expense_message'] = "Expense added successfully!";
    } else {
        // Set error message in the session
        $_SESSION['expense_status'] = "error";
        $_SESSION['expense_message'] = "Error while adding expense: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();

    // Redirect the user to the expense page
    header('Location: ../sites/expense_page.php');
}

// Close the database connection
$connection->close();
?>
