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
$total_expenses = 0;
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND amount IS NOT NULL";
$result = $connection->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_expenses = $row['total'];
    if($total_expenses == NULL)
    {
        $total_expenses = 0;
    }
}

// Obliczanie sumy dochodów
$total_income = 0;
$sql = "SELECT income FROM user WHERE id='$user_id'";
$result = $connection->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_income = $row['income'];
}

function isZero(float $total_income, float $total_expenses){
	if($total_income == 0){
		return 0;
	}
	else return number_format((($total_expenses*100)/$total_income)-100, 3);
}

// Obliczanie podsumowania budżetu
$budget_summary = $total_income - $total_expenses;
$calculations = isZero($total_income, $total_expenses);
$budget_percent = $calculations - ($calculations*2);


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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
                <p>Dark mode</p>
                <div class="theme-btn">
                    <span class="theme-ball"></span>
                </div>
            </div>
    </section>

    <div id="main">
        
        <div class="item">
        <p>Całkowite Dochód: <?php echo $total_income; ?>zł</p><br>
        <button class="item-btn" onClick="openPopUpIncome()">Dodaj Dochód</button>
        </div>
        <div class="item">
        <p>Całkowite wydatki: <?php echo "&nbsp;".$total_expenses; ?>zł</p><br>
        <button class="item-btn" id="openModal" onClick="openPopUpExpenses()">Dodaj wydatki</button>
        </div>
        <div class="item">
        <p>Kapitał: <br> <?php echo $budget_summary; ?>zł</p>
        <button class="item-btn" href="#">Podsumowanie</button>
        </div>
        <div class="item">
            <p>Procent oszczędności:</p> <span id="percent"><?php echo $budget_percent ?>% <i class="fa-solid fa-arrow-up"></i></span>
        </div>
        <div class="item">       
            <div id="myChart" style="position: relative; height:40vh; width:80vw"></div>
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
        <button class="item-btn"type="submit" name="submit_expense" onClick="closeOpenPopUpExpenses()"><i class="fa-solid fa-plus"></i> Dodaj wydatek</button>
        <button id="pop-up-close" class="item-btn-close" onClick="closeOpenPopUpExpenses()">Zamknij Okno</button>

    </form>
    </div>
    </div>


    

</body>

<script src="./js/menu.js"></script>
<script src="./js/charts.js"></script>
<script src="./js/pop_up.js"></script>
</html>