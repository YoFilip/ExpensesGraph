<?php
session_start();
require_once "../php/connect.php";

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

require_once "../php/dashboard_php.php";
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExpensesGraph</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="icon" href="../favicon.ico" type="image/icon">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    
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
                <div id="myChart"></div>
            </div>
        </div>
    </div>
</section>

</body>

<script>
    // Convert PHP datasets to JavaScript
    var chartDatasets = <?php echo json_encode($datasets); ?>;
    
    // Chart configuration options
    var options = {
        colors: ['#007BFF', '#EA031B', '#00DF61', '#EAE903'], 
        series: chartDatasets,
        chart: {
            type: 'area',
            stacked: false,
            height: 350,
            zoom: {
                enabled: true
            },
        },
        dataLabels: {
            enabled: false
        },
        markers: {
            size: 0,
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100, 100, 100]
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#8e8da4',
                },
                offsetX: 0,
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        xaxis: {
            categories: <?php echo json_encode($dates); ?>,
            type: 'date',
            tickAmount: <?php echo sizeof($dates); ?>
        },
        title: {
            text: 'ㅤ',
            align: 'center',
            offsetX: 14
        },
        tooltip: {
            shared: true
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            offsetX: -10
        },
    };

    // Create and render the chart
    var chart = new ApexCharts(document.querySelector("#myChart"), options);
    chart.render();
</script>

</html>
