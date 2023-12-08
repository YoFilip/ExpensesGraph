<?php
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno == 0) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Register Page</title>
    <link rel="stylesheet" href="./css/login.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/6215660fb9.js" crossorigin="anonymous"></script>
</head>

<body>
<section class="sidebar">
        <div class="nav-header">
            <p class="logo">TU <span>NAZWA</span> </p>
            <i class="bx bx-menu btn-menu"></i>
        </div>
        <ul class="nav-links">
            <li>
                <i class="bx bx-search search-btn"></i>
                <input type="text" id="searchInput" placeholder="Wyszukaj..." />
                <span class="tooltip">Search...</span>
            </li>

            <li class="dropdown">
                <a href="home.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="title">Home</span>
                </a>
                
                <span class="tooltip">Home</span>
            </li>

            <li class="dropdown">
                <a href="logout.php">
                <i class='bx bx-log-out'></i>
                    <span class="title">
                    Wyloguj</span>
                </a>
               
                
                <span class="tooltip">Home</span>
            </li>


            <li class="dropdown">
                <a href="register.php">
                <i class='bx bx-log-out'></i>
                    <span class="title">
                    Rejestracja</span>
                </a>
               
                
                <span class="tooltip">Rejestracja</span>
            </li>

            <div class="theme-wrapper">
                <i class="bx bxs-moon theme-icon"></i>
                <p>Dark Mode</p>
                <div class="theme-btn">
                    <span class="theme-ball"></span>
                </div>
            </div>
    </section>


    <div id="main">

        <form action="register.php" method="post">
            Username: <br /> <input type="text" name="username" required /> <br />
            Email: <br /> <input type="email" name="email" required /> <br />
            Password: <br /> <input type="password" name="password" required /> <br /><br />
            <input type="submit" value="Register" />
            <a href="login_page.php" id="login_a">Zaloguj się</a>
        </form>
  
    </div>

</body>

<script src="./js/menu.js"></script>
</html>

