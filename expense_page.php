<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login_page.php');
    exit();
}

?>
<!DOCTYPE html>
<htm lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
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
                            <a href="dashboard.php" >Home</a>
                        </li>
                        <li>
                            <a href="raports_page.php">Raports</a>
                        </li>
                        <li>
                            <a href="income_page.php">Add Income</a>
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

  <section>
    <div class="container">
      
      <h1>Add Expense Form</h1>
      <div class="row">
      </div>
      <div class="row">
        <div class="card-02">
          
       
            <form action="add_expense.php" method="post">
                Date: <br /> <input type="date" name="date" required /> <br />
                Description: <br /> <input type="text" name="description" required /> <br />
                Expense Amount: <br /> <input type="number" name="amount" step="0.01" required /> <br />
                
                <select name="category">
                    <?php
                    require_once "connect.php";

                    $connection = new mysqli($host, $db_user, $db_password, $db_name);

                    if ($connection->connect_errno != 0) {
                        echo "Error: " . $connection->connect_errno;
                        exit();
                    }

                    $sql = "SELECT * FROM categories";
                    $result = $connection->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['categorie_id'] . "'>" . $row['title'] . "</option>";
                    }
                    ?>
                </select> 
                <button class="item-btn" type="submit" name="submit_expense">Add an expense</button>
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
<?php if (isset($_SESSION['expense_status'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let type = '<?php echo $_SESSION['expense_status']; ?>';
        let icon = type === 'success' ? 'check_circle' : 'warning';
        let title = type === 'success' ? 'Success' : 'Error';
        let text = '<?php echo $_SESSION['expense_message']; ?>';
        createToast(type, icon, title, text);

        <?php unset($_SESSION['expense_status']); ?>
        <?php unset($_SESSION['expense_message']); ?>
    });
</script>
<?php endif; ?>



</html>