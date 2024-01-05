<?php
session_start();
require_once "../php/connect.php";

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
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/scrollbar.css">
        <title>ExpensesGraph</title>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
        <style>
            form {
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

            form input {
                margin-top: 10px;
                width: 300px;
                height: 30px;
                padding: 6px
            }

            form input[type=email],
            input[type=password] {
                text-transform: lowercase;
            }

            form input[type=email]:hover,
            input[type=password]:hover {
                border: 1px solid var(--text);
            }

            form button.item-btn {
                width: 300px;
                height: 40px;
                background-color: var(--text);
                border: none;
                color: #fff;
                transition: all 1s;
                margin-top: 20px;
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
                max-width: 60%;
                min-width: 354px;
            }

            textarea {
                resize: none;
                width: 300px;
                height: 100px;
            }
            #not-found{
                font-size:30px;
                margin-bottom:50px;
                margin-top: -50px;
            }

            .notesBtn{
                margin-top:20px;
            }

            /*======Notes styles=======*/
.note{
    border: 3px solid var(--text);
  display: flex;
  flex-direction: column;
  flex-wrap: wrap;
  text-align: center;
  margin-bottom: 30px;
  flex-wrap: wrap;
  margin: 10px;
  width: auto;
  min-width: 80%;
  max-width: 100px;
  padding: 10px;
}
#root{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}
form h2{
  margin-bottom: 15px;
  margin-top: 20px;
}

.notesBtn{
  width: 120px;
  height: 30px;
  background-color: var(--text);
  border: none;
  color: #fff;
  transition: all 1s; 
  margin-bottom: 10px;
}

#formNone{
  padding: 0;
}
.delateBtn{
  margin-top: -150px;
  width: 120px;
  height: 30px;
  background-color: var(--text);
  border: none;
  color: #fff;
  transition: all 1s;
  margin-bottom: 10px;
}
#changeForm{
    display: flex;
    flex-wrap: wrap;
    min-width: 500px;
}
.note #changeForm{

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
                            <span class="material-symbols-outlined"> join_left </span>
                            <h1>ExpensesGraph</h1>
                            <input type="checkbox" id="nav_check" hidden>
                            <nav>
                                <ul>
                                    <li>
                                        <a href="dashboard.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="raports_page.php">Raports</a>
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
                            <button class="item-btn" type='submit'>Dodaj notatkę</button>
                        </form>
                        <div id="root"> 
            <?php

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
                    <span class = 'changeBtn'><button class='notesBtn' id='". $row['id'] ."' onclick = 'changeNote(this.id)'>Zmień notatkę</button></span>
                    </div>";
                }
            else
                echo "<div>
                <h1 id='not-found'>No Notes found!</h1>
                </div>";
        ?> </div>
                    </div>
                </div>
            </div>
            </main>
            <!--Cards layout end-->
        </section>
    </body> <?php if (isset($_SESSION['income_status'])): ?> <script>
        document.addEventListener('DOMContentLoaded', function() {
            let type = '<?php echo $_SESSION['
            income_status ']; ?>';
            let icon = type === 'success' ? 'check_circle' : 'warning';
            let title = type === 'success' ? 'Success' : 'Error';
            let text = '<?php echo $_SESSION['
            income_message ']; ?>';
            createToast(type, icon, title, text); < ? php unset($_SESSION['income_status']); ? > < ? php unset($_SESSION['income_message']); ? >
        });
    </script> <?php endif; ?> <script src="../js/changeNote.js"></script>

    </html>