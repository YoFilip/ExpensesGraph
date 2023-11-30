<?php
    session_start();
    
    if (!isset($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Table</title>
</head>
<body>
    <h1>Data Table</h1>
    <a href="logout.php">Log out</a>
</body>
</html>
