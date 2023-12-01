<?php
session_start();

if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in'] == true)) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login Page</title>
</head>

<body>

    <form action="login.php" method="post">
        Email: <br /> <input type="email" name="email" required/> <br />
        Password: <br /> <input type="password" name="password" required /> <br /><br />
        <input type="submit" value="Log in" />
    </form>


    <a href="register.php">Zarejestruj się</a>

    <?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?>
</body>

</html>
