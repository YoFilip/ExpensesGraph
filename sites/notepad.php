<?php require_once "../php/connect.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses notepad</title>
</head>
<body>
    
    <form method="post" action="../php/add_note.php">
        <table>

            <tr>
                <td>
                    <label for="title">Tytuł:</label>
                </td>
                <td>
                    <input type="text" name='title'>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="content">Zawartość:</label>
                </td>
                <td>
                    <textarea type="text" name='content' rows="4" cols="40"></textarea>
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
                    <h2>".$row['title']."</h2>
                    <p>".$row['content']."</p>
                    <p>".$row['date']."</p>
                    </div>";
                }
            else
                echo "<div>
                <h1>No Notes found!</h1>
                </div>";
        ?>
    </div>

</body>
</html>
