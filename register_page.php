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
            $_SESSION['registration_success'] = "Rejestracja przebiegła pomyślnie!";
        } else {
            $_SESSION['registration_error'] = "Błąd podczas rejestracji: " . $connection->error;
        }
        $connection->close();
        
}}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@200&family=Changa:wght@300&family=Orbitron&family=Roboto:wght@500&display=swap');
        form{
        background-color: var(--white);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: var(--text);
        width: auto;
        height: auto;
        padding: 100px 150px 100px 150px;
        }
        form input{
            margin-bottom: 10px;
            width: 300px;
            height: 30px;
            padding: 6px
        }
        form input[type=email],input[type=password]{
            text-transform:lowercase;
        }

        form input[type=email]:hover,input[type=password]:hover{
            border: 1px solid var(--text);
            padding: 12px 20px;
        }
        form input[type=submit]{
            width: 300px;
            height: 40px;
            background-color: var(--text);
            border: none;
            color: #fff;
            transition: all 1s; 
        }  
        form input[type=submit]:hover{
            width: 325px;
            height: 50px;
        }
        form label{
            margin-bottom: 10px;
        }
        #login_a{
            margin-top: 20px;
            color: var(--text);
            text-decoration: underline;
        }
        .card-02{
            height: auto;
        }
    </style>
</head>
<body>
    
    <!--Header section-->
    <section>
        <div class="header">
            <div class="row">
            <div class="card-03">
                <header>
                    <span class="material-symbols-outlined">
                        join_left
                    </span>
                        <h1>ExpensesGraph</h1>
                    <input type="checkbox" id="nav_check" hidden>
                    <nav>
                        <ul>
                            <li>
                                <a href="login_page.php">Sign In</a>
                            </li>
                        </ul>
                    </nav>
                    <label for="nav_check" class="hamburger">
                        <div></div>
                        <div></div>
                        <div></div>
                    </label>
                </header>
            </div>
            </div>
        </div>
    </section>
    <!--end Header section-->


    <!--Cards layout start-->
    <section>
        <div class="container">
        
            <h1>Sign Up Now</h1>
            
            <div class="row">
            <div class="card-02">
            <form action="register_page.php" method="post">
                <label>Username:</label><input type="text" name="username" required /> <br />
                <label>Email:</label><input type="email" name="email" required /> <br />
                <label>Password:</label><input type="password" name="password" required /> <br /><br />
                <input type="submit" value="Sign Up" />

                <a href="login_page.php" id="login_a">Sign In</a>
            </form>

            </div>
            </div>
        </div>
        </main>
    </section> 
    <!--Cards layout end-->
</body>
</html>


