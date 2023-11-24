<?php

require_once "config.php";
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM user WHERE email = '$email';";


?>