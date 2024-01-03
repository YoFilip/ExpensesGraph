
<?php
require_once "connect.php";

session_start();

require('../fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();

$conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Błąd: ".$conn->errno);

$user_id = $_SESSION['id'];

$query = "SELECT expenses.*, SUM(expenses.amount) AS sum categories.title AS category_title 
FROM expenses 
JOIN categories ON expenses.expense_id = categories.categorie_id 
WHERE expenses.user_id = '$user_id'";

// $res = $conn->query($query);

// $sum = 0;

// if($res)
// {
//     while($row = $res->fetch_assoc())
//     {
//         $sum = $row['sum'];
//     }
// }

$pdf->setFont('Arial', 'B', 30);

$pdf->Cell(0, 10, utf8_decode("User raport"), 0 , 1, "C");
$pdf->Ln();

$pdf->setFont('Arial', '', 15);
// $pdf->Cell(0, 10, "Wydatki: $sum");

$pdf->Output();
?>
								