<?php
session_start();
require_once "../php/connect.php";
if (!isset($_SESSION['logged_in'])) {
    header('Location: login_page.php');
    exit();
}

$expense_id = $_GET['id'] ?? null;
if (!$expense_id) {
    echo "No expense ID provided";
    exit();
}

$connection = new mysqli($host, $db_user, $db_password, $db_name);
if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
    exit();
}

// Fetch the expense data
$sql = "SELECT * FROM expenses WHERE id = $expense_id";
$result = $connection->query($sql);
if (!$result) {
    echo "Error fetching data";
    exit();
}

$expense = $result->fetch_assoc();
if (!$expense) {
    echo "Expense not found";
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
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@200&family=Changa:wght@300&family=Orbitron&family=Roboto:wght@500&display=swap');
     form{
    background-color: var(--white);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: var(--text);
    width: auto;
    height: auto;
    padding: 100px 150px 100px 150px;
    }
    form input{
        margin-top: 10px;
        width: 300px;
        height: 30px;
        padding: 6px
    }
    form input[type=email],input[type=password]{
        text-transform:lowercase;
    }

    form input[type=email]:hover,input[type=password]:hover{
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

    form label{
        margin-bottom: 10px;
    }
    #login_a{
        margin-top: 20px;
        color: var(--text);
        text-decoration: underline;
    }
    .material-symbols-outlined{
        font-size: 45px;
    }
    .card-02{
        height: 35rem;
       
    }
    select{
        border: 1px solid black;
        margin-bottom: 40px;
    }


    </style>
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

    <!--Cards layout start-->
    <section>
        <div class="container">
        
            <h1>Edit Expense</h1>
            
            <div class="row">
            <div class="card-02">
            


            <form action="../php/update_expense.php" method="post">
    <input type="hidden" name="id" value="<?php echo $expense['id']; ?>" />

    Date: <br /> <input type="date" name="date" value="<?php echo $expense['date']; ?>" required /> <br />
    Description: <br /> <input type="text" name="description" value="<?php echo $expense['description']; ?>" required /> <br />
    Expense Amount: <br /> <input type="number" name="amount" step="0.01" value="<?php echo $expense['amount']; ?>" required /> <br />
    
    <select name="category">
    <?php
    $sql_categories = "SELECT * FROM categories";
    $result_categories = $connection->query($sql_categories);
    while ($category_row = $result_categories->fetch_assoc()) {
        $selected = ($expense['expense_id'] == $category_row['categorie_id']) ? 'selected' : '';
        echo "<option value='" . $category_row['categorie_id'] . "' $selected>" . $category_row['title'] . "</option>";
    }
    ?>
</select>

    <button class="item-btn" type="submit" name="submit_expense">Update Expense</button>
</form>
                
                <div class="notifications"></div>
            </div>
          </div>


           
        </div>
        </main>
        <!--Cards layout end-->
    </section> 
</body>
<script src="./js/notifications.js"></script>
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