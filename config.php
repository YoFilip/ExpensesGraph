<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "expensesgraphdb";

$conn = new mysqli($host, $user, $password, $db) or die($conn->connect_error);
?>