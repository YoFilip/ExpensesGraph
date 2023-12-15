<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION['logged_in'])) {
    header('Location: login_page.php');
    exit();
}

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
    exit();
}

$user_id = $_SESSION['id'];

if (isset($_POST['submit_expense'])) {
    $date = $_POST['date'];
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $amount = $_POST['amount'];
    $category_id = $_POST['category'];

    $sql = "INSERT INTO expenses (user_id, date, description, amount, expense_id) VALUES ('$user_id', '$date', '$description', '$amount', '$category_id')";

    if ($connection->query($sql)) {
        $_SESSION['expense_status'] = "success";
        $_SESSION['expense_message'] = "Expense added successfully!";
    } else {
        $_SESSION['expense_status'] = "error";
        $_SESSION['expense_message'] = "Error while adding expense: " . $connection->error;
    }
    
    header('Location: expense_page.php');     
}

$connection->close();
?>
