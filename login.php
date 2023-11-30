<?php
    session_start();

    if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in'] == true)) {
        header('Location: tabela.php');
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
    <form action="zaloguj.php" method="post">
        Username: <br /> <input type="text" name="username" /> <br />
        Password: <br /> <input type="password" name="password" /> <br /><br />
        <input type="submit" value="Log in" />
    </form>

    <?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?>
</body>

</html>
