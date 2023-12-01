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

// Obliczanie sumy wydatków
$total_expenses = 0;
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND amount IS NOT NULL";
$result = $connection->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_expenses = $row['total'];
}

// Obliczanie sumy dochodów
$total_income = 0;
$sql = "SELECT income FROM user WHERE id='$user_id'";
$result = $connection->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $total_income = $row['income'];
}

// Obliczanie podsumowania budżetu
$budget_summary = $total_income - $total_expenses;

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8" />
    <title>Tabela Wydatków</title>
</head>
<body>
    <h1>Tabela Wydatków</h1>
    <a href="logout.php">Wyloguj</a>

    <h2>Podsumowanie Budżetu</h2>
    <p>Całkowite zarobki: <?php echo $total_income; ?><br>
       Całkowite wydatki: <?php echo $total_expenses; ?><br>
       Stan budżetu: <?php echo $budget_summary; ?></p>

    <h2>Dodaj Dochód</h2>
    <form action="add_expense.php" method="post">
        Kwota Dochodu: <br /> <input type="number" name="profit" step="0.01" required /> <br />
        <input type="submit" name="submit_income" value="Dodaj dochód" />
    </form>

    <h2>Dodaj Wydatek</h2>
    <form action="add_expense.php" method="post">
        Data: <br /> <input type="date" name="date" required /> <br />
        Opis: <br /> <input type="text" name="description" required /> <br />
        Kwota Wydatku: <br /> <input type="number" name="amount" step="0.01" required /> <br />
        <input type="submit" name="submit_expense" value="Dodaj wydatek" />
    </form>

    <h2>Wydatki</h2>
    <?php
    $sql = "SELECT date, description, amount FROM expenses WHERE user_id='$user_id' AND amount IS NOT NULL ORDER BY date DESC";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'><tr><th>Data</th><th>Opis</th><th>Kwota</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["date"] . "</td><td>" . $row["description"] . "</td><td>" . $row["amount"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Brak wydatków.";
    }
    $connection->close();
    ?>
</body>
</html>
