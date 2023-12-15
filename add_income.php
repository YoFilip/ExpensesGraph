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

if (isset($_POST['submit_income'])) {
    $income_amount = $_POST['income_amount'];

    $sql = "UPDATE user SET income = income + '$income_amount' WHERE id = '$user_id'";

    if ($connection->query($sql)) {
        $_SESSION['income_status'] = "success";
        $_SESSION['income_message'] = "Income added successfully!";
    } else {
        $_SESSION['income_status'] = "error";
        $_SESSION['income_message'] = "Error while adding income: " . $connection->error;
    }
    
    header('Location: income_page.php'); 
}

$connection->close();
?>
