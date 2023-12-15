<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION['logged_in'])) {
    header('Location: login_page.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $category_id = $_POST['category'];


    $connection = new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection->connect_errno != 0) {
        echo "Error: " . $connection->connect_errno;
        exit();
    }


    $sql = "UPDATE expenses SET date = '$date', description = '$description', amount = $amount, expense_id = $category_id WHERE id = $id";
    if ($connection->query($sql)) {

        header('Location: raports_page.php');
    } else {
        echo "Error updating record: " . $connection->error;
    }
}
?>
