<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/scrollbar.css">
    <title>ExpensesGraph</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        form {
            background-color: var(--white);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: var(--text);
            width: auto;
            height: auto;
            padding: 100px 150px 50px 150px;
        }

        form input {
            margin-top: 10px;
            width: 300px;
            height: 30px;
            padding: 6px;
        }

        form input[type=email], input[type=password] {
            text-transform: lowercase;
        }

        form input[type=email]:hover, input[type=password]:hover {
            border: 1px solid var(--text);
        }

        form select {
            margin-top: 30px;
            width: 140px;
            height: 30px;
            padding: 6px;
            margin-right: 5px;
        }

        form .select-container {
            display: flex;
            justify-content: space-between;
            width: 300px;
        }

        form button.item-btn {
            width: 300px;
            height: 40px;
            background-color: var(--text);
            border: none;
            color: #fff;
            transition: all 1s;
            margin-top: 20px;
        }

        form button.item-btn:hover {
            width: 325px;
            height: 50px;
        }

        form label {
            margin-bottom: 10px;
        }

        #login_a {
            margin-top: 20px;
            color: var(--text);
            text-decoration: underline;
        }

        .material-symbols-outlined {
            font-size: 45px;
        }

        .card-02 {
            height: auto;
            padding: 30px;
        }

        #result {
            margin-top: 20px;
            text-align: center;
            font-size: 40px;
            margin-bottom: 20px;
        }

        #exchange-rates-table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }

        #exchange-rates-table th, #exchange-rates-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #exchange-rates-table th {
            background-color: var(--text);
            color: #fff;
            border-radius:0;
        }

    </style>
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
                            <li><a href="raports_page.php">Raports</a></li>
                            <li><a href="income_page.php">Add Income</a></li>
                            <li><a href="expense_page.php">Add Expense</a></li>
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

<script>
    function updateExchangeRates() {
        var apiKey = 'bf07853c4b1f54b8310b3b15';
        var fromCurrency = document.getElementById('from-currency').value;
        var exchangeRatesUrl = 'https://v6.exchangerate-api.com/v6/' + apiKey + '/latest/' + fromCurrency;

        fetch(exchangeRatesUrl)
            .then(response => response.json())
            .then(data => {
                var rates = data.conversion_rates;
                var tableBody = document.getElementById('exchange-rates-body');
                tableBody.innerHTML = '';

                for (var currency in rates) {
                    var row = tableBody.insertRow();
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    cell1.innerHTML = currency;
                    cell2.innerHTML = rates[currency];
                }
            })
            .catch(error => {
                console.error('Error fetching exchange rates:', error);
            });
    }

    setInterval(updateExchangeRates, 250);

    function calculateCurrency() {
        var amount = document.getElementById('amount').value;
        var fromCurrency = document.getElementById('from-currency').value;
        var toCurrency = document.getElementById('to-currency').value;
        var apiKey = 'bf07853c4b1f54b8310b3b15';
        var apiUrl = 'https://v6.exchangerate-api.com/v6/' + apiKey + '/latest/' + fromCurrency;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                var exchangeRate = data.conversion_rates[toCurrency];
                var result = amount * exchangeRate;
                document.getElementById('result').innerHTML = 'Converted currency: ' + result.toFixed(2) + ' ' + toCurrency;
            })
            .catch(error => {
                console.error('Error fetching exchange rates:', error);
            });
    }
</script>

</body>
</html>
