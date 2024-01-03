<?php
session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: ../sites/login_page.php');
    exit();
}

require_once "connect.php";
$connection = new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
} else {
    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT id, user, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();


if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();
    
    if (password_verify($password, $hashed_password)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['id'] = $id;
        $_SESSION['user'] = $username;

        unset($_SESSION['error']);
        $stmt->close();
        $connection->close();
        header('Location: ../sites/dashboard.php');
    } else {
        $_SESSION['error'] = 'Invalid email or password!';
        header('Location: ../sites/login_page.php');
    }
} else {
    $_SESSION['error'] = 'Invalid email or password!';
    header('Location: ../sites/login_page.php');
}

}
?>
