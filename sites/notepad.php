<?php
session_start();
require_once "../php/connect.php";

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
    <link rel="stylesheet" href="../css/notepad.css">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <!--Header section-->
    <section>
        <div class="header">
            <div class="row">
                <div class="card-03">
                    <header>
                        <span class="material-symbols-outlined"> join_left </span>
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
            <h1>Your Notes</h1>
            <div class="row">
                <div class="card-02">
                    <form method="post" action="../php/add_note.php">
                        <label for="title">Title:</label>
                        <input type="text" name='title' id='title'>
                        <label for="content">Description:</label>
                        <textarea type="text" name='content' id='content' rows="4" cols="40"></textarea>
                        <button class="item-btn" type='submit'>Add Note</button>
                    </form>
                    <div id="root">
                        <?php
                        $conn = new mysqli($host, $db_user, $db_password, $db_name);

                        $query = "SELECT * FROM notepad WHERE user_id =" . $_SESSION['id'];
                        $res = $conn->query($query);

                        if ($res->num_rows > 0)
                            foreach ($res as $row) {
                                echo "<div class='note'>    
                                        <h2 class='title'>" . $row['title'] . "</h2>
                                        <p class='content'>" . $row['content'] . "</p>
                                        <p>" . $row['date'] . "</p>
                                        <span class='changeBtn'><button class='notesBtn' id='" . $row['id'] . "' onclick='changeNote(this.id)'>Edit Note</button></span>
                                    </div>";
                            }
                        else
                            echo "<div>
                                    <h1 id='not-found'>No Notes found!</h1>
                                  </div>";
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
</body>

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

<script src="../js/changeNote.js"></script>

</html>
