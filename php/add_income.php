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

// Check if the income submission form has been submitted
if (isset($_POST['submit_income'])) {
    // Retrieve data from the form
    $income_amount = $_POST['income_amount'];

    // Prepare and execute the SQL query to update user income
    $sql = "UPDATE user SET income = income + '$income_amount' WHERE id = '$user_id'";

    if ($connection->query($sql)) {
        // Set success message in the session
        $_SESSION['income_status'] = "success";
        $_SESSION['income_message'] = "Income added successfully!";
    } else {
        // Set error message in the session
        $_SESSION['income_status'] = "error";
        $_SESSION['income_message'] = "Error while adding income: " . $connection->error;
    }

    // Redirect the user to the income page
    header('Location: ../sites/income_page.php');
}

// Close the database connection
$connection->close();
?>
