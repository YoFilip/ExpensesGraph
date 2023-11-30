<?php
    session_start();

    if ((!isset($_POST['username'])) || (!isset($_POST['password']))) {
        header('Location: login.php');
        exit();
    }

    require_once "connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0) {
        echo "Error: " . $connection->connect_errno;
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // SQL injection prevention
        $username = htmlentities($username, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        if ($result = @$connection->query(sprintf("SELECT * FROM user WHERE user='%s' AND password='%s'", mysqli_real_escape_string($connection, $username), mysqli_real_escape_string($connection, $password)))) {
            $num_users = $result->num_rows;
            if ($num_users > 0) {
                $_SESSION['logged_in'] = true;

                $row = $result->fetch_assoc();
                $_SESSION['id'] = $row['id'];
                $_SESSION['user'] = $row['user'];

                unset($_SESSION['error']);
                $result->free_result();
                echo "<script>localStorage.setItem('loggedIn', 'true');</script>";
                header('Location: tabela.php');
            } else {
                $_SESSION['error'] = '<span style="color:red">Invalid username or password!</span>';
                header('Location: login.php');
            }
        }

        $connection->close();
    }
?>
