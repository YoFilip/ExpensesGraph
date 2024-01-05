<?php require_once "../php/connect.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses notepad</title>
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
                                    <a href="currency_page.php">Currency Calculator</a>
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
    
    <form method="post" action="../php/add_note.php">
        <table>

            <tr>
                <td>
                    <label for="title">Tytuł:</label>
                </td>
                <td>
                    <input type="text" name='title' id='title'>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="content">Zawartość:</label>
                </td>
                <td>
                    <textarea type="text" name='content' id='content' rows="4" cols="40"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <button type='submit'>Dodaj notatkę</button>
                </td>
            </tr>

        </table>
    </form>

    <div id="root">
        <?php
            session_start();

            $conn = new mysqli($host, $db_user, $db_password, $db_name);

            $query = "SELECT * FROM notepad WHERE user_id =". $_SESSION['id'];

            $res = $conn->query($query);

            if($res->num_rows > 0)
                foreach($res as $row)
                {
                    echo "<div class='note'>    
                    <h2 class='title'>".$row['title']."</h2>
                    <p class='content'>".$row['content']."</p>
                    <p>".$row['date']."</p>
                    <span class = 'changeBtn'><button id = '". $row['id'] ."' onclick = 'changeNote(this.id)'>Zmień notatkę</button></span>
                    </div>";
                }
            else
                echo "<div>
                <h1>No Notes found!</h1>
                </div>";
        ?>
    </div>

    <script src="../js/changeNote.js"></script>

</body>
</html>
