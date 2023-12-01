<?php
session_start();
require_once "connect.php";

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

if (isset($_POST['submit_expense'])) {
    $date = $_POST['date'];
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $amount = $_POST['amount'];

    $sql = "INSERT INTO expenses (user_id, date, description, amount) VALUES ('$user_id', '$date', '$description', '$amount')";

    if ($connection->query($sql)) {
        echo "Wydatek dodany pomyślnie!";
    } else {
        echo "Błąd podczas dodawania wydatku: " . $connection->error;
    }
}

if (isset($_POST['submit_income'])) {
    $profit = $_POST['profit'];

    $sql = "UPDATE user SET income = income + '$profit' WHERE id = '$user_id'";

    if ($connection->query($sql)) {
        echo "Dochód dodany pomyślnie!";
    } else {
        echo "Błąd podczas dodawania dochodu: " . $connection->error;
    }
}

$connection->close();

header('Location: tabela.php');
?>
