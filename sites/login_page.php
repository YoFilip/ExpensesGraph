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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <!--Header section-->
    <section>
        <div class="header">
            <div class="row">
                <div class="card-03">
                    <header>
                        <span class="material-symbols-outlined">join_left</span>
                        <h1>ExpensesGraph</h1>
                        <input type="checkbox" id="nav_check" hidden>
                        <nav>
                            <ul>     
                                <li><a href="register_page.php">Sign Up</a></li>
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

    <!-- Cookie Popup -->
    <div class="popup" id="myForm">
        <h1>Cookie Policy</h1>
        <p>This website uses cookies to ensure the best quality of services. Please read our <a href="#">cookie policy</a> to learn more.</p>
        <button type="button" class="close-button" id="acceptCookiesButton" onclick="acceptCookies(event)">I Agree</button>
        <button type="button" class="close-button" id="rejectCookiesButton" onclick="rejectCookies(event)">I Disagree</button>
    </div>

    <section>
        <div class="container">

            <h1>Sign In Now</h1>

            <div class="row">
                <div class="card-02">
                    <form action="../php/login.php" method="post" id="login_page">
                        <label>Email:</label><input type="email" name="email" required/>
                        <label>Password: </label> <input type="password" name="password" required />
                        <input type="submit" value="Sign In" />
                        <a href="register_page.php" id="login_a">Sign Up</a>
                    </form>

                    <div class="notifications"></div>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="../js/notifications.js"></script>
<script src="../js/cookie.js"></script>
<?php if (isset($_SESSION['error'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let type = 'error';
            let icon = 'warning';
            let title = 'Error';
            let text = '<?php echo $_SESSION['error']; ?>';
            createToast(type, icon, title, text);
            <?php unset($_SESSION['error']); ?>
        });
    </script>
<?php endif; ?>

</html>
