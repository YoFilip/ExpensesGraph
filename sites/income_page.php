<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login_page.php');
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
    <link rel="stylesheet" href="../css/income.css">
    <link rel="icon" href="../favicon.ico" type="image/icon">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

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
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <li><a href="raports_page.php">Reports</a></li>
                                <li><a href="notepad.php">Notepad</a></li>
                                <li><a href="income_page.php">Add Income</a></li>
                                <li><a href="expense_page.php">Add Expense</a></li>
                                <li><a href="currency_page.php">Currency Calculator</a></li>
                                <li><a href="../php/logout.php">Sign Out</a></li>
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

    <section>
        <div class="container">
            <h1>Add Income Form</h1>
            <div class="row">
                <div class="card-02">
                    <form action="../php/add_income.php" method="post">
                        Income Amount: <br /> <input type="number" name="income_amount" step="0.01" required /> <br />
                        <button class="item-btn" type="submit" name="submit_income">Add Income</button>
                    </form>
                    <div class="notifications"></div>
                </div>
            </div>
        </div>
    </section>

</body>

<script src="../js/notifications.js"></script>

<?php if (isset($_SESSION['income_status'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let type = '<?php echo $_SESSION['income_status']; ?>';
            let icon = type === 'success' ? 'check_circle' : 'warning';
            let title = type === 'success' ? 'Success' : 'Error';
            let text = '<?php echo $_SESSION['income_message']; ?>';
            createToast(type, icon, title, text);

            <?php unset($_SESSION['income_status']); ?>
            <?php unset($_SESSION['income_message']); ?>
        });
    </script>
<?php endif; ?>

</html>
