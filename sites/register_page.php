<?php
// Start the session to manage user sessions
session_start();
require_once "../php/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    // Check for database connection errors
    if ($connection->connect_errno == 0) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (user, email, password) VALUES ('$username', '$email', '$password')";

        if ($connection->query($sql)) {
            $_SESSION['registration_success'] = "Registration was successful!";
        } else {
            $_SESSION['registration_error'] = "Error during registration!" . $connection->error;
        }

        // Close the database connection
        $connection->close();
    }
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
    <link rel="stylesheet" href="../css/register.css">
    <link rel="icon" href="../favicon.ico" type="image/icon">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <!-- Header section -->
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
                                <li><a href="login_page.php">Sign In</a></li>
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

    <!-- Cookie Pop up -->
    <div class="popup" id="myForm">
        <h1>Cookie Policy</h1>
        <p>This website uses cookies to ensure the best quality of services. Please read our <a href="#">cookie policy</a> to learn more.</p>
        <button type="button" class="close-button" id="acceptCookiesButton" onclick="acceptCookies(event)">I Agree</button>
        <button type="button" class="close-button" id="rejectCookiesButton" onclick="rejectCookies(event)">I Disagree</button>
    </div>

    <!-- Cards layout start -->
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
                    <div class="notifications"></div>
                </div>
            </div>
        </main>
    </section>
</body>
<?php if (isset($_SESSION['registration_success'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let type = 'success';
            let icon = 'check_circle';
            let title = 'Success';
            let text = '<?php echo $_SESSION['registration_success']; ?>';
            createToast(type, icon, title, text);
            <?php unset($_SESSION['registration_success']); ?>
        });
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['registration_error'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let type = 'error';
            let icon = 'warning';
            let title = 'Error';
            let text = '<?php echo $_SESSION['registration_error']; ?>';
            createToast(type, icon, title, text);
            <?php unset($_SESSION['registration_error']); ?>
        });
    </script>
<?php endif; ?>

<script src="../js/notifications.js"></script>
<script src="../js/cookie.js"></script>
</html>
