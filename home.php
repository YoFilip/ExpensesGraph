<?php
session_start();
require_once "connect.php";


function getRandomColor()
{
    $colorArr = ['0','1','2','3','4','5','6','7','8','9', 'A', 'B', 'C', 'D', 'E', 'F'];

    $color = "#";
    while(strlen($color) < 7)
    {
        $color .= $colorArr[rand(0, 15)];
    }
    return $color;

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

$total_expenses = 0; //Wydatki
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND amount IS NOT NULL";
$result = $connection->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_expenses = $row['total'] * (-1);
	
    if($total_expenses == NULL)
    {
        $total_expenses = 0;
    }
}

$total_income = 0; // Dochód
$sql = "SELECT income FROM user WHERE id='$user_id'";
$result = $connection->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_income = $row['income'];
}

function isZero(float $total_income, float $total_expenses){
	if($total_income == 0){
		return 0;
	}
	else return number_format(((($total_expenses*100)/$total_income)+100)*(-1), 2);
}

$budget_summary = $total_income + $total_expenses;
$calculations = isZero($total_income, $total_expenses);
$budget_percent = $calculations - ($calculations*2);

$sql = "SELECT SUM(amount) as total, date, expense_id FROM expenses WHERE user_id='$user_id' GROUP BY date, expense_id ORDER BY date";
$result = $connection->query($sql);
$expensesData = [];
while ($row = $result->fetch_assoc()) {
    $expensesData[] = $row;
    // $expensesData = [...$expensesData, 
    //     'expense_id' => $row['expense_id'],
    //     'date' => $row['date'],
    //     'total' => $row['total']
    // ];
}

$dateArr = [];

$categories = []; 
foreach ($expensesData as $expense) {
    $category_id = $expense['expense_id'];
    $date = $expense['date'];
    $amount = $expense['total'];

    $dateArr += [$date => $amount];

    if (!isset($categories[$category_id])) {
        $categories[$category_id] = ['data' => [], 'label' => '']; 
    }
    $categories[$category_id]['data'][$date] = $amount;
}

ksort($dateArr);

$sql = "SELECT categorie_id, title FROM categories";
$result = $connection->query($sql);
while ($row = $result->fetch_assoc()) {
    if (isset($categories[$row['categorie_id']])) {
        $categories[$row['categorie_id']]['label'] = $row['title'];
    }
}

$datasets = [];

$keys = array_keys($dateArr);
$vals = array_values($dateArr);

foreach ($categories as $category) {
    $datasets[] = [
        'label' => $category['label'],
        'data' => $vals,
        'borderColor' => getRandomColor(), 
        'fill' => false,
    ];
}


?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="./scrollbar.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/6215660fb9.js" crossorigin="anonymous"></script>
    
    <!--Charts.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
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

            <div class="theme-wrapper">
                <i class="bx bxs-moon theme-icon"></i>
                <p>Dark Mode</p>
                <div class="theme-btn">
                    <span class="theme-ball"></span>
                </div>
            </div>
    </section>

    <div id="main">
        
        <div class="item">
        <p>Dochód:<br><?php echo $total_income; ?>zł</p>
        <button class="item-btn" onClick="openPopUpIncome()">Dodaj Dochód</button>
        </div>
        <div class="item">
        <p>Wydatki:<br><?php echo $total_expenses; ?>zł</p>
        <button class="item-btn" id="openModal" onClick="openPopUpExpenses()">Dodaj wydatki</button>
        </div>
        <div class="item">
        <p>Kapitał:<br> <?php echo $budget_summary; ?>zł</p>
        <button class="item-btn" href="#">Podsumowanie</button>
        </div>
        <div class="item">
            <p>Procent oszczędności:</p> <span id="percent"><?php echo $budget_percent ?>% <i class="fa-solid fa-arrow-up"></i></span>
        </div>
        <div class="item">       
            <canvas id="myChart" style="position: relative; height:40vh; width:80vw"></canvas>
        </div>

    <div id="pop-up-1">
    <h2>Dodaj Dochód</h2><br>
    <form action="add_expense.php" method="post">
        <p class="form-p">Kwota Dochodu: <br /> <input type="number" name="profit" step="0.01"/> <br /></p>
        <button class="item-btn"type="submit" name="submit_income"><i class="fa-solid fa-plus"></i> Dodaj dochód</button><br>
        <button id="pop-up-close" class="item-btn-close" onClick="popUpCloseIncome()">Zamknij Okno</button>
    </form>
    </div>

    <div id="pop-up-2">
    <h2>Dodaj wydatek</h2><br>
    <form action="add_expense.php" method="post">
        Data: <br /> <input type="date" name="date" required /> <br />
        Opis: <br /> <input type="text" name="description" required /> <br />
        Kwota Wydatku: <br /> <input type="number" name="amount" step="0.01" required /> <br />
        Kategoria: <br />
        <select name="category">
        <?php
        $sql = "SELECT * FROM categories";
        $result = $connection->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['categorie_id'] . "'>" . $row['title'] . "</option>";
        }
        ?>
    </select> <br />
        <button class="item-btn"type="submit" name="submit_expense" onClick="closeOpenPopUpExpenses()"><i class="fa-solid fa-plus"></i> Dodaj wydatek</button>
        <button id="pop-up-close" class="item-btn-close" onClick="closeOpenPopUpExpenses()">Zamknij Okno</button>

    </form>
    </div>
    </div>


    

</body>

<script src="./js/menu.js"></script>
<script>
    var chartLabels = <?php echo json_encode($keys); ?>;
    var chartDataSets = <?php echo json_encode($datasets); ?>;
    console.log(chartLabels);
</script>
<!-- <script src="./js/charts.js"></script> -->

<script>

// new Chart(document.getElementById("myChart"), {
//     type: 'line',
//     data: {
//         labels: ['2023-12-04', '2023-12-05', '2023-12-06', '2023-12-07', '2023-12-12', '2023-12-13', '2023-12-14', '2023-12-15', '2023-12-18', '2023-12-19', '2023-12-21', '2023-12-22', '2023-12-25', '2023-12-26', '2023-12-27', '2023-12-29'],
//         datasets: [
//             {
//                 data: [52, 101, 108, 131, 251, 284, 296, 329, 335, 373, 377, 386, 410, 446, 467],
//                 label: "Dom",
//                 borderColor: "#3cba9f",
//                 fill: false,
//             },
//             {
//                 data: [42, 94, 179, 180, 321, 403, 409, 497, 502, 538, 566, 582, 587, 613, 638, 666],
//                 label: "Dzieci",
//                 borderColor: "#e43202",
//                 fill: false,
//             },
//         ],
//     },
//     options: {
//         title: {
//             display: true,
//             text: "WYKRES WYDATKÓW",
//         },
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         },
//         plugins: {
//             zoom: {
//                 pan: {
//                     enabled: true,
//                     mode: 'x',
//                     rangeMax: {
//                         x: 100000,
//                     },
//                     rangeMin: {
//                         x: 1750,
//                     },
//                 },
//                 zoom: {
//                     enabled: true,
//                     mode: 'xy',
//                     rangeMax: {
//                         x: 10000,
//                     },
//                     rangeMin: {
//                         x: 1750,
//                     },
//                 },
//             },
//         },
//     },
// });






new Chart(document.getElementById("myChart"), {
    type: 'line',
     type: 'line',
        data: {
            labels: chartLabels,
            datasets: chartDataSets
        },
    options: {
        title: {
            display: true,
            text: "WYKRES WYDATKÓW",
        },
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            zoom: {
                pan: {
                    enabled: true,
                    mode: 'x',
                    rangeMax: {
                        x: 100000,
                    },
                    rangeMin: {
                        x: 1750,
                    },
                },
                zoom: {
                    enabled: true,
                    mode: 'xy',
                    rangeMax: {
                        x: 10000,
                    },
                    rangeMin: {
                        x: 1750,
                    },
                },
            },
        },
    },
});






</script>


<script src="./js/pop_up.js"></script>
</html>