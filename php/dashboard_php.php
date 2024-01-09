<?php

// Retrieve total expenses for the user
$sql = "SELECT SUM(amount) AS total FROM expenses WHERE user_id='$user_id' AND amount IS NOT NULL";
$result = $connection->query($sql);
$total_expenses = ($result && $row = $result->fetch_assoc()) ? floatval($row['total']) : 0;

// Retrieve user income
$sql = "SELECT income FROM user WHERE id='$user_id'";
$result = $connection->query($sql);
$total_income = ($result && $row = $result->fetch_assoc()) ? floatval($row['income']) : 0;

// Function to calculate the budget percentage based on income and expenses.
function calculateBudgetPercentage(float $total_income, float $total_expenses): float {
    if ($total_income == 0) {
        return 0;
    } else {
        // Sanitize and validate input values
        $total_expenses = filter_var($total_expenses, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $total_income = filter_var($total_income, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if (is_numeric($total_expenses) && is_numeric($total_income) && $total_income != 0) {
            $percentage = (($total_expenses * 100) / $total_income) - 100;
            $formatted_percentage = sprintf("%.5f", $percentage * (-1));

            return number_format($formatted_percentage, 2, '.', '');
        } else {
            return 0;
        }
    }
}

// Calculate budget summary and percentage
$budget_summary = $total_income - $total_expenses;
$budget_percent = calculateBudgetPercentage($total_income, $total_expenses);

// Fetch unique dates and total expenses for each date
$dates = [];
$sql = "SELECT SUM(amount) as total, date, expense_id, description FROM expenses WHERE user_id='$user_id' GROUP BY date ORDER BY date";
$result = $connection->query($sql);
$expensesData = [];
while ($row = $result->fetch_assoc()) {
    $dates[] = $row['date'];
    $expensesData[] = $row;
}

// Separate expenses data into different categories
$dataArr1 = [];
$dataArr2 = [];
$dataArr3 = [];
$dataArr4 = [];

foreach ($expensesData as $expense) {
    $category_id = $expense['expense_id'];
    $date = $expense['date'];
    $amount = $expense['total'];

    switch($category_id) {
        case 1:
            $dataArr1[] = [$date => $amount];
            break;
        case 2:
            $dataArr2[] = [$date => $amount];
            break;
        case 3:
            $dataArr3[] = [$date => $amount];
            break;
        case 4:
            $dataArr4[] = [$date => $amount];
            break;
    }
}
    

// Initialize datasets array
$datasets = [];

// Loop through each data array and create corresponding dataset
foreach([$dataArr1, $dataArr2, $dataArr3, $dataArr4] as $index => $dataArr) {
    $data = [];

    foreach($dataArr as $d1_val) {
        foreach($d1_val as $d => $d_val) {
            $data[] = [findIndex($dates, $d), $d_val];
        }
    }

    $datasets[] = [
        'name' => getCategoryName($index + 1),
        'data' => $data
    ];
}

/**
 * Function to find the index of a value in an array.
*/
function findIndex(array $arr, $val): int {
    foreach($arr as $i => $value) {
        if($value == $val) {
            return $i + 1;
        }
    }
    return 0; // Return 0 if value not found
}

/**
 * Function to get category name based on category ID.
 */
function getCategoryName(int $categoryId): string {
    switch($categoryId) {
        case 1:
            return 'Fun';
        case 2:
            return 'Home';
        case 3:
            return 'Food';
        case 4:
            return 'Health';
        default:
            return 'Unknown';
    }
}
?>