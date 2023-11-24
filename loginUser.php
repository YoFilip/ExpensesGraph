<?php
require_once "config.php";
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
$query = "SELECT * FROM user WHERE email ='$email' AND password = '$password' LIMIT 1;";

$conn->query($query) or die($conn->errno);

$row = $res->fetch_assoc();

$_SESSION['id'] = $row['id'];
$_SESSION['name'] = $row['name'];

header("location: index.php");

?>