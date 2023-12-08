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

    <form action="login.php" method="post" id="login_page">
        Email:<input type="email" name="email" required/>
        Password:  <input type="password" name="password" required /> 
        <input type="submit" value="Log in" />
        <a href="register.php" id="login_a">Zarejestruj się</a>
    </form>
  
</div>



    

    <?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?>
</body>

<script src="./js/menu.js"></script>
</html>
