<?php
session_start();
require_once "../php/connect.php";

if (!isset($_SESSION['logged_in'])) {
    header('Location: login_page.php');
    exit();
}

$connection = new mysqli($host, $db_user, $db_password, $db_name);

// Check for database connection errors
if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
    exit();
}

$user_id = $_SESSION['id'];
$sql = "SELECT expenses.*, categories.title AS category_title 
        FROM expenses 
        JOIN categories ON expenses.expense_id = categories.categorie_id 
        WHERE expenses.user_id = '$user_id'";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <link rel="stylesheet" href="../css/raport.css">
    <link rel="icon" href="../favicon.png" type="image/icon">
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
            <h1>Your Raport</h1>
            <div class="row">
                <div class="card-02">
                    <div class="charts">
                        <div class="item-chart">
                            <div class="chart"></div>
                        
                        </div>
                    </div>
                </div>
            </div>
            <div id="pdf">
                <form action="../php/create_file.php">
                    <button class="btn btn-edit" type='submit' id='pdfBtn' target='_blank'
                        style="width:300px;border:none;height:70px;margin:0;font-size:20px">Download Raport PDF</button>
                </form>
            </div>
            <div class="row">
                <div class="card-02" style="overflow-x:auto;">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['date'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['amount'] . " zł</td>";
                                echo "<td>" . $row['category_title'] . "</td>";
                                echo "<td>";
                                echo "<a href='edit_expense_page.php?id=" . $row['id'] . "' class='btn btn-edit'>Edit</a>";
                                echo "<a class='btn btn-delete' data-id='" . $row['id'] . "'>Delete</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No expenses recorded</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                var id = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this record?')) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../php/delete_record.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (this.status == 200) {
                            location.reload();
                        }
                    };
                    xhr.send('id=' + id);
                }
            });
        });

        <?php
        $valArr = [];

        for ($i = 1; $i <= 4; ++$i) {
            $sql = "SELECT SUM(amount) as sum FROM expenses WHERE user_id = '$user_id' AND expense_id = $i";

            $res = $connection->query($sql);

            if ($res) {
                $val = $res->fetch_assoc();
                $valArr[] = $val['sum'];
            }
        }

        $sum = 0;

        foreach ($valArr as $val) {
            $sum += $val;
        }

        $sql = "SELECT income FROM user WHERE id = '$user_id'";

        $res = $connection->query($sql);

        if ($res) {
            $val = $res->fetch_assoc();
            $valArr[] = $val['income'];
        }

        $income = $valArr[4];
        ?>

        <?php if ($sum < $income):?>
            var options1 = {
                series: [
                    <?php echo $valArr[0] ?? 0; ?>,
                    <?php echo $valArr[1] ?? 0; ?>,
                    <?php echo $valArr[2] ?? 0; ?>,
                    <?php echo $valArr[3] ?? 0; ?>,
                    <?php echo $valArr[4] - $sum; ?>
                ],
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: ['Fun', 'Home', 'Food', 'Health', 'Income'],
                colors: ['#007BFF', '#EA031B', '#00DF61', '#EAE903', '#0F1626'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'center'
                        }
                    }
                }]
            };

            var chart1 = new ApexCharts(document.getElementsByClassName('chart')[0], options1);
            chart1.render();
        <?php else: ?>
            document.getElementsByClassName('chart')[0].innerHTML = '<p class="error-chart">Your income is negative. The chart cannot be generated.</p>';
        <?php endif; ?>
    });
</script>

</html>
