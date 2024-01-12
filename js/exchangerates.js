function updateExchangeRates() {
    var apiKey = '374dd95e97da0106b314c6bb';
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

setInterval(updateExchangeRates, 300000000000);

function calculateCurrency() {
    var amount = document.getElementById('amount').value;
    var fromCurrency = document.getElementById('from-currency').value;
    var toCurrency = document.getElementById('to-currency').value;
    var apiKey = '374dd95e97da0106b314c6bb';
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
    updateExchangeRates();
};