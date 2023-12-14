<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION['logged_in'])) {
    header('Location: login_page.php');
    exit();
}

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
    exit();
}

$user_id = $_SESSION['id'];

// Obliczanie sumy wydatków
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND amount IS NOT NULL";
$result = $connection->query($sql);
$total_expenses = ($result && $row = $result->fetch_assoc()) ? floatval($row['total']) : 0;

// Obliczanie sumy dochodów
$sql = "SELECT income FROM user WHERE id='$user_id'";
$result = $connection->query($sql);
$total_income = ($result && $row = $result->fetch_assoc()) ? floatval($row['income']) : 0;

// Funkcja do obliczania procentu budżetu
function calculateBudgetPercentage(float $total_income, float $total_expenses) {
    if ($total_income == 0) {
        return 0;
    } else {
        return number_format((($total_expenses * 100) / $total_income) - 100,2)*(-1);
    }
}

// Obliczanie podsumowania budżetu
$budget_summary = $total_income - $total_expenses;
$budget_percent = calculateBudgetPercentage($total_income, $total_expenses);
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExpensesGraph</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
                            <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li>
                                <a href="#">Raports</a>
                            </li>
                            <li>
                                <a href="logout.php">Sign Out</a>
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
        <h1>Your Expenses</h1>
        <div class="row">
            <div class="card-01">
                <h4>Total Income</h4>
                <p><?php echo $total_income; ?>zł</p>
            </div>
            <div class="card-01">
                <h4>Total Expenses</h4>
                <p><?php echo -$total_expenses; ?>zł</p>
            </div>
            <div class="card-01">
                <h4>Budget Summary</h4>
                <p><?php echo $budget_summary ?>zł</p>
                <div class="percentage-change">
                    <span><?php echo $budget_percent ?>%</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-02">
                <div id="myChart">
                </div>
            </div>
        </div>
    </div>
</section> 
<!--Cards layout end-->
</body>
<script src="./js/charts.js"></script>
</html>
