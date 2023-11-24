<?php

    require_once "config.php";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password1'];

    $query = "SELECT * FROM user WHERE email = '$email';";

    $res = $conn->query($query) or die($conn->errno);
    if($res->num_rows > 0)
    {
        echo "Adres email jest już zajęty. Czy chcesz się zalogować?";
        echo "<a href='login.html'>Zaloguj się</a>";
        echo "<a href='register.html'>Spróbuj ponownie</a>";
        exit();
    }

    $query = "INSERT INTO user(name, email, password) VALUES('$name', '$email', '$password')";

    if($conn->query($query))
    {
        header("location: login.html");
    }
    else
    {
        die($conn_>errno);
    }

?>