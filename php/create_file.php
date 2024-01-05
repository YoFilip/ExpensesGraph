
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
        $pdf->Cell($col_length, $col_height, $row['amount'], 1, 0, 'C');
        $pdf->Cell($col_length, $col_height, $row['category_title'], 1, 0, 'C');
        $pdf->Cell($col_length, $col_height, $row['date'], 1, 1, 'C');
    }
}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$res = $conn->query("SELECT income FROM user WHERE id = '$user_id'");

if ($res) {
    $temp = $res->fetch_assoc();
    $income = $temp['income'];
    $pdf->Cell(0, 10, "Income: ".$income."pln");
}
else{
    $pdf->Cell(0, 10, "Income: None");
}
$pdf->Output();
?>
								