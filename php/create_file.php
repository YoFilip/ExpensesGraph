
<?php
require_once "connect.php";

session_start();

require('../fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();

function generateTip($pdf, $categorieId, $tipsArr)
{
    switch($categorieId)
    {
        case 0:
            $pdf->Write(10, "Tip: ".$tipsArr[0][rand(0, 4)], 0, 0, 'C');
            break;
        case 1:
            $pdf->Write(10, "Tip: ".$tipsArr[1][rand(0, 4)]);
            break;
        case 2:
            $pdf->Write(10, "Tip: ".$tipsArr[2][rand(0, 4)]);
            break;
        case 3:
            $pdf->Write(10, "Tip: ".$tipsArr[3][rand(0, 4)]);
            break;
    }
}

function getMaxIndxValue($sumArr)
{
    $temp = 0;

    for($i = 0; $i < sizeof($sumArr); ++$i)
    {
        if($sumArr[$i] > $temp)
            $temp = $i;
    }

    return $temp;
}

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

$sumArr = [];

for($i = 1; $i <= 4; ++$i)
{
    $res = $conn->query("SELECT SUM(amount) as sum FROM expenses WHERE user_id = '$user_id' AND expense_id = $i");

    if($res)
    {
        $temp = $res->fetch_assoc();
        $sumArr[] = $temp['sum'];
    }
}

$tipsArr = [
    [
        "Cost optimization in entertainment starts with attending free cultural events. Local events, exhibitions, or concerts not only save money but also provide an opportunity to enjoy culture without significant expenses.",
        "Limiting subscriptions to streaming services is a conscious decision to minimize entertainment expenses. Choose only those that are essential to maintain high-quality entertainment while simultaneously reducing monthly costs.",
        "Searching for offers and discount coupons for tourist attractions is a proven way to lower costs related to outings. Utilize available promotions to enjoy entertainment without burdening your wallet excessively.",
        "Planning social gatherings at home is not just a way to save money but also to create a pleasant atmosphere in a intimate setting. Organizing home gatherings can be equally satisfying as going out to restaurants or clubs.",
        "Exploring alternative, free forms of entertainment such as walks, reading books from the library, or watching free online movies is a way to actively spend time without the need for additional expenses.",
    ],
    [
        "Optimizing expenses for home insurance is key to long-term savings. Regularly comparing offers and adjusting the policy to current needs allows maintaining adequate home protection at minimal costs.",
        "Energy savings are not only an ecological practice but also a way to reduce bills for utilities. Investments in energy-efficient technologies and conscious management of energy consumption positively affect household finances.",
        "Systematic analysis of bills for utilities is a strategy that allows eliminating unnecessary costs. Conscious use of services and avoiding impulsive purchases are key to effective household budget management.",
        "Home shopping planning is not only an effective method to avoid impulsive purchases but also a way to consciously manage finances. A shopping list is a tool that helps maintain control over expenses and eliminate unnecessary purchases.",
        "Investing in modern technologies, such as budget management apps, facilitates monitoring expenses and planning the household budget. This is an effective tool for controlling and optimizing costs.",
    ],
    [
        "Food cost optimization can begin with experimenting with seasonal products. By choosing cheaper and seasonally available items, you not only save money but also introduce healthy changes to your diet, benefiting from the richness of fresh ingredients, contributing to improved health.",
        "Take advantage of the benefits of bulk purchases. Buying in bulk allows you to benefit from attractive discounts, positively impacting the household budget. Long-term shopping planning is not only about saving but also conscious financial management.",
        "Prepare a set of healthy snacks for the entire week in advance. This idea not only simplifies meal planning but also eliminates the need for expensive, unhealthy snacks in moments of hunger. It's a simple way to maintain a healthy lifestyle at minimal costs.",
        "Use technology to consciously manage your food budget. Mobile apps offering promotions in grocery stores are excellent tools for finding the best deals and saving on daily grocery shopping.",
        "Improving cooking skills is an investment in health and savings. Learning to prepare simple, tasty dishes at home not only makes eating cheaper but also allows you to consciously control the quality of ingredients, contributing to better well-being and health.",
    ],
    [
        "Regular physical activity is not only a prescription for improving health but also a way to achieve long-term savings. Investing in physical fitness can contribute to reducing costs associated with healthcare in the future.",
        "Considering changing health insurance depending on changing needs is a strategic approach to managing healthcare costs. Adjusting the policy to current requirements can significantly impact the household budget.",
        "Regular preventive check-ups are not only an investment in your own health but also an effective way to minimize treatment costs by early detection of potential health issues.",
        "Exploring alternative health care methods, such as home therapies or dietary supplements, is an effective strategy to optimize costs associated with healthcare. Utilize natural methods supporting health, contributing to a reduction in expenses.",
        "Considering cheaper substitutes for medications and actively searching for available discounts are practical steps toward optimizing expenses for pharmacotherapy. Choosing economical solutions can significantly impact the household budget while simultaneously caring for health.",
    ]
];


$res = $conn->query(
    $query = "SELECT expenses.*, categories.title AS category_title 
    FROM expenses 
    JOIN categories ON expenses.expense_id = categories.categorie_id 
    WHERE expenses.user_id = '$user_id'
    ORDER BY date");

$pdf->setFont('Arial', 'B', 30);

$pdf->Cell(0, 10, utf8_decode("User raport"), 0 , 1, "C");
$pdf->Ln();

$pdf->setFont('Arial', 'B', 20);
$pdf->Cell(0, 10, "Your expenses: ", 0, 1);
$pdf->Ln();

$pdf->setFont('Arial', '', 15);

// Setting universal column width/length
$col_length = 47;

// Setting universal column height
$col_height = 10;

$pdf->Cell($col_length, $col_height, "Description", 1, 0, 'C');
$pdf->Cell($col_length, $col_height, "Amount", 1, 0, 'C');
$pdf->Cell($col_length, $col_height, "Category", 1, 0, 'C');
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

$pdf->setFont('Arial', '', 15);
$pdf->Cell(0, 10, "Expenses: ".$sum."pln");
$pdf->Ln();
$pdf->Write(10, "Account balance: ".($income['income'] - $sum)."pln");
$pdf->Ln();
$pdf->Ln();

$percentage = ($sum * 100) / $income['income'];

$pdf->Cell(0, 10, "Your expenses consume ".$percentage."% of your income.", 0, 0, 'C');
$pdf->Ln();
$pdf->Ln();
// Stan konta


generateTip($pdf, getMaxIndxValue($sumArr), $tipsArr);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->setFont('Arial', '', 14);

$text = "Expense percentages:
-Fun consumes ".round(($sumArr[0] * 100)/$sum)."%;
-home consumes ".round(($sumArr[1] * 100)/$sum)."%;
-food consumes ".round(($sumArr[2] * 100)/$sum)."%;
-health consumes ".round(($sumArr[3] * 100)/$sum)."%";

$pdf->Write(10, $text);
$pdf->Output('D', 'raport.pdf');
?>