    <?php
    session_start();
    require_once "../php/connect.php";

    function findIndex($arr, $val)
        {
            for($i = 0; $i < sizeof($arr); ++$i)
            {
                if($arr[$i] == $val)
                    return $i + 1;
            }
        }

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



    function calculateBudgetPercentage(float $total_income, float $total_expenses) {
        if ($total_income == 0) {
            return 0;
        } else {

    $total_expenses = filter_var($total_expenses, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $total_income = filter_var($total_income, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if (is_numeric($total_expenses) && is_numeric($total_income) && $total_income != 0) {
        $percentage = (($total_expenses * 100) / $total_income) - 100;
        $formatted_percentage = sprintf("%.5f", $percentage * (-1));

        return number_format($formatted_percentage, 2, '.', '');
    } else {
        return 0;
    }

            
        }
    }


    // Obliczanie podsumowania budżetu
    $budget_summary = $total_income - $total_expenses;
    $budget_percent = calculateBudgetPercentage($total_income, $total_expenses);

    $dates = [];

        $sql = "SELECT SUM(amount) as total, date,
        expense_id, description FROM expenses WHERE
        user_id='$user_id' GROUP BY date ORDER BY date";
        $result = $connection->query($sql);
        $expensesData = [];
        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['date'];
            $expensesData[] = $row;
        }

        
        $dataArr1 = [];
        $dataArr2 = [];

        foreach ($expensesData as $expense) {
            $category_id = $expense['expense_id'];
            $date = $expense['date'];
            $amount = $expense['total'];

            if($category_id == 1)
                $dataArr1[] = [$date => $amount];
            else if($category_id == 2)
                $dataArr2[] = [$date => $amount];
        }
        $data = [];
        foreach($dataArr1 as $d1 => $d1_val)
        {
            foreach($d1_val as $d => $d_val)
            {
                $data[] = [findIndex($dates, $d), $d_val];
            }
        }

        $datasets = [];



        $dataset1[] = [
            'name' => 'Work',
            'data' => $data
        ];

        $data = [];
        foreach($dataArr2 as $d1 => $d1_val)
        {
            foreach($d1_val as $d => $d_val)
            {
                $data[] = [findIndex($dates, $d), $d_val];
            }
        }

        $dataset2[] = [
            'name' => 'Home',
            'data' => $data 
        ];

        $datasets = array_merge($dataset1, $dataset2);


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
                                    <a href="raports_page.php">Raports</a>
                                </li>
                                <li>
                                    <a href="income_page.php">Add Income</a>
                                </li>
                                <li>
                                    <a href="expense_page.php">Add Expense</a>
                                </li>
                                <li>
                                    <a href="../php/logout.php">Sign Out</a>
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
<script>
var chartDatasets = <?php echo json_encode($datasets); ?>;
var options = {
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
        categories: <?php echo json_encode($dates);?>,
        type: 'date',
        tickAmount: <?php echo sizeof($dates);?>
        },
        title: {
          text: 'Expenses',
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

        var chart = new ApexCharts(document.querySelector("#myChart"), options);
        chart.render();
</script>
</html>
