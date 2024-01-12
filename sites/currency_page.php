<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <link rel="stylesheet" href="../css/currency.css">
    <link rel="icon" href="../favicon.png" type="image/icon">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
<section>
    <div class="header">
        <div class="row">
            <div class="card-03">
                <header>
                    <span class="material-symbols-outlined">join_left</span>
                    <h1>ExpensesGraph</h1>
                    <input type="checkbox" id="nav_check" hidden>
                    <nav>
                        <ul>
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="raports_page.php">Reports</a></li>
                            <li><a href="notepad.php">Notepad</a></li>
                            <li><a href="income_page.php">Add Income</a></li>
                            <li><a href="expense_page.php">Add Expense</a></li>
                            <li><a href="currency_page.php">Currency Calculator</a></li>
                            <li><a href="../php/logout.php">Sign Out</a></li>
                        </ul>
                    </nav>
                    <label for="nav_check" class="hamburger">
                        <div></div>
                        <div></div>
                        <div></div>
                    </label>
                </header>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h1>Currency Calculator</h1>
        <div class="row">
            <div class="card-02">
                <form id="currency-form">
                    <label for="amount">Income Amount:</label>
                    <input type="number" id="amount" step="0.01" required />

                    <div class="select-container">
                        <select id="from-currency" required>
                            <option value="PLN">PLN</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                        </select>

                        <select id="to-currency" required>
                            <option value="PLN">PLN</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                        </select>
                    </div>

                    <button class="item-btn" type="button" onclick="calculateCurrency()">Calculate</button>
                </form>

                <div id="result"></div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="card-02">
                <table id="exchange-rates-table">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Exchange Rate</th>
                        </tr>
                    </thead>
                    <tbody id="exchange-rates-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</body>
    <script src="../js/exchangerates.js"></script>
</html>
