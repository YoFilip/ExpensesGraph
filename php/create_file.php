
<?php
require_once "connect.php";

session_start();

require('../fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();

$conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Błąd: ".$conn->errno);

$user_id = $_SESSION['id'];

$query = "SELECT SUM(expenses.amount) AS sum FROM expenses WHERE expenses.user_id = '$user_id'";

$res = $conn->query($query);

$sum = 0;

if($res)
{
    while($row = $res->fetch_assoc())
    {
        $sum = $row['sum'];
    }
}

$res = $conn->query("SELECT SUM(amount) as sum FROM expenses WHERE user_id = '$user_id' AND expense_id = 1");

$work = 0;

if($res)
{
    $temp = $res->fetch_assoc();
    $work = $temp['sum'];
}

$res = $conn->query("SELECT SUM(amount) as sum FROM expenses WHERE user_id = '$user_id' AND expense_id = 2");

$home = 0;

if($res)
{
    $temp = $res->fetch_assoc();
    $home = $temp['sum'];
}

$res = $conn->query(
    $query = "SELECT expenses.*, categories.title AS category_title 
    FROM expenses 
    JOIN categories ON expenses.expense_id = categories.categorie_id 
    WHERE expenses.user_id = '$user_id'
    ORDER BY date");

$pdf->setFont('Arial', 'B', 30);

$pdf->Cell(0, 10, utf8_decode("User raport"), 0 , 1, "C");
$pdf->Ln();
$pdf->Ln();

$pdf->setFont('Arial', '', 15);
$pdf->Cell(0, 10, "Expenses: ".$sum."pln");
$pdf->Ln();
$pdf->Ln();

$pdf->setFont('Arial', 'B', 20);
$pdf->Cell(0, 10, "Your expenses: ", 0, 1, "C");
$pdf->Ln();

$pdf->setFont('Arial', '', 15);

// Setting universal column width/length
$col_length = 47;

// Setting universal column height
$col_height = 10;

$pdf->Cell($col_length, $col_height, "Description", 1, 0, 'C');
$pdf->Cell($col_length, $col_height, "Amount", 1, 0, 'C');
$pdf->Cell($col_length, $col_height, "Categorie", 1, 0, 'C');
$pdf->Cell($col_length, $col_height, "Date", 1, 1, 'C');

if($res)
{
    foreach($res as $row)
    {
        $pdf->Cell($col_length, $col_height, $row['description'], 1, 0, 'C');
        $pdf->Cell($col_length, $col_height, $row['amount']."pln", 1, 0, 'C');
        $pdf->Cell($col_length, $col_height, $row['category_title'], 1, 0, 'C');
        $pdf->Cell($col_length, $col_height, $row['date'], 1, 1, 'C');
    }
}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$res = $conn->query("SELECT income FROM user WHERE id = '$user_id'");

$income = [];

if ($res) {
    $income = $res->fetch_assoc();
    $income['income'] = (int)$income['income'];
    $pdf->Cell(0, 10, "Income: ". $income['income'] ."pln");
}
else{
    $pdf->Cell(0, 10, "Income: None");
    $pdf->Output();
}

$pdf->Ln();
$pdf->Ln();

$percentage = ($sum * 100) / $income['income'];

$pdf->Cell(0, 10, "Your expenses consume ".$percentage."% of your income.", 0, 0, 'C');
$pdf->Ln();
$pdf->Ln();

$pdf->setFont('Arial', '', 14);

$pdf->Write(10, "Work consumes ".round(($work * 100)/$sum)."% of your expenses while home consumes the remaining ".round(($home * 100)/$sum)."%.");
$pdf->Output('D', 'raport.pdf');
?>
								