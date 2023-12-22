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
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@200&family=Changa:wght@300&family=Orbitron&family=Roboto:wght@500&display=swap');

        form {
            background-color: var(--white);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: var(--text);
            width: auto;
            height: auto;
            padding: 78px 106px;
        }

        form input {
            margin-top: 10px;
            width: 300px;
            height: 30px;
            padding: 10px;
            border: 1px solid black;
        }

        form input[type=email], input[type=password] {
            text-transform: lowercase;
        }

        form input[type=email]:hover, input[type=password]:hover {
            border: 1px solid var(--text);
        }

        form button.item-btn {
            width: 300px;
            height: 40px;
            background-color: var(--text);
            border: none;
            color: #fff;
            transition: all 1s;
        }

        form button.item-btn:hover {
            width: 325px;
            height: 50px;
        }

        form label {
            margin-bottom: 10px;
        }

        #login_a {
            margin-top: 20px;
            color: var(--text);
            text-decoration: underline;
        }

        .material-symbols-outlined {
            font-size: 45px;
        }

        .card-02 {
            height: auto;
            border: none;
        }

        #delete-btn, #edit-btn {
            width: 100px;
            height: 40px;
            margin: 7px;
            border: none;
            border-radius: 5px;
        }

        #delete-btn {
            background: red;
        }

        #edit-btn {
            background: #F0AE4C;
        }

        .popup{
            border: 1px solid black;
        }

        .btn {
        display: inline-block;
        padding: 8px 20px;
        background-color: #007bff;
        color: white;
        text-align: center;
        border-radius: 5px;
        text-decoration: none;
        margin-right:20px;
        cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }


    </style>
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
                                <li><a href="dashboard.php">Home</a></li>
                                <li><a href="#">Raports</a></li>
                                <li><a href="income_page.php">Add Income</a></li>
                                <li><a href="expense_page.php">Add Expense</a></li>
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
            <div class="row"></div>
            <div class="row">
                <div class="card-02">
                    <div class="notifications"></div>
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
                                echo "<a href='./sites/edit_./expense_page.php?id=" . $row['id'] . "' class='btn btn-edit'>Edit</a>";
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
<script src="../js/notifications.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var id = this.getAttribute('data-id');
            if(confirm('Are you sure you want to delete this record?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../php/delete_record.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status == 200) {
                        location.reload();
                    }
                };
                xhr.send('id=' + id);
            }
        });
    });
});

</script>
</html>
