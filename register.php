<?php
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno == 0) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "SELECT * FROM user WHERE email = '$email'";

        $res = $connection->query($sql);

        if($res->num_rows > 0)
            die("Konto już istnieje! <a href='login_page.php'>Zaloguj</a>");

        $sql = "INSERT INTO user (user, email, password) VALUES ('$username', '$email', '$password')";

        if ($connection->query($sql)) {
            echo "Rejestracja przebiegła pomyślnie!";
        } else {
            echo "Błąd podczas rejestracji: " . $connection->error;
        }

        $connection->close();
    } else {
        echo "Błąd połączenia z bazą danych: " . $connection->connect_errno;
    }
}
?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="post">
        Username: <br /> <input type="text" name="username" required /> <br />
        Email: <br /> <input type="email" name="email" required /> <br />
        Password: <br /> <input type="password" name="password" required /> <br /><br />
        <input type="submit" value="Register" />
    </form>

    <a href="login_page.php">Zaloguj się</a>
</body>
</html>

