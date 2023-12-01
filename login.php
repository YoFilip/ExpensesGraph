<?php
session_start();

if ((!isset($_POST['email'])) || (!isset($_POST['password']))) {
    header('Location: login_page.php');
    exit();
}

require_once "connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
} else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = htmlentities($email, ENT_QUOTES, "UTF-8");

    if ($result = @$connection->query(sprintf("SELECT * FROM user WHERE email='%s'", mysqli_real_escape_string($connection, $email)))) {
        $num_users = $result->num_rows;
        if ($num_users > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['user'] = $row['username'];

                unset($_SESSION['error']);
                $result->free_result();
                header('Location: tabela.php');
            } else {
                $_SESSION['error'] = '<span style="color:red">Invalid email or password!</span>';
                header('Location: login_page.php');
            }
        } else {
            $_SESSION['error'] = '<span style="color:red">Invalid email or password!</span>';
            header('Location: login_page.php');
        }
    }

    $connection->close();
}
?>
