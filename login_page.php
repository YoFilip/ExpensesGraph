<?php
session_start();

if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in'] == true)) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
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
    }
    form input[type=submit]{
        width: 300px;
        height: 40px;
        background-color: var(--text);
        border: none;
        margin-top: 20px;
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
                                <a href="register_page.php">Sign Up</a>
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
        
            <h1>Sign In Now</h1>
            
            <div class="row">
            <div class="card-02">
            <form action="login.php" method="post" id="login_page">
                <label>Email:</label><input type="email" name="email" required/>
                <label>Password: </label> <input type="password" name="password" required /> 
                <input type="submit" value="Sign In" />
              
                <a href="register_page.php" id="login_a">Sign In</a>
            </form>
        

            </div>
            </div>
        </div>
        </main>
        <!--Cards layout end-->
    </section> 
</body>
</html>







    




