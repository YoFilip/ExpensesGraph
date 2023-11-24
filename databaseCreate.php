<?php
$host = "localhost";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password);

$conn->query("CREATE DATABASE expensesGraphDB");


?>