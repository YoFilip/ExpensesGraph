<?php
require_once "config.php"; // Tutaj załóżmy, że masz plik konfiguracyjny do połączenia z bazą danych

// Zapytanie do pobrania nazw kategorii z bazy danych
$query = "SELECT category_name FROM categories";
$result = mysqli_query($link, $query); // Zakładam, że używasz MySQLi

$categories = array();

while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['category_name'];
}

mysqli_close($link);
?>


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
    <title>Charts Page</title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

    #chart ,#myChart{
        width: 1500px;
        height: 300px;
        display: flex;
        margin: auto;
    }
    h1{
        text-align: center;
    }
    </style>
</head>
<body>
<div>
<h1>Wydatki</h1>
<div id="chart">
  <canvas id="myChart" ></canvas>
</div>

</div>

</body>

<script>

    
  var categories = <?php echo json_encode($categories); ?>;

    new Chart(document.getElementById("myChart"), {
    type: 'line',
    data: {
        labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050, 1999, 2050,],
        datasets: [{
            data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478, 783, 2478],
            label: categories,
            borderColor: "#3e95cd",
            fill: false
        }, {
            data: [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
            label: categories,
            borderColor: "#8e5ea2",
            fill: false
        }, {
            data: [168, 170, 178, 190, 203, 276, 408, 547, 675, 734],
            label: categories,
            borderColor: "#3cba9f",
            fill: false
        }, {
            data: [40, 20, 10, 16, 24, 38, 74, 167, 508, 784],
            label: categories,
            borderColor: "#e8c3b9",
            fill: false
        }, {
            data: [6, 3, 2, 2, 7, 26, 82, 172, 312, 433],
            label: categories,
            borderColor: "#c45850",
            fill: false
        }
        ]
    },
    options: {
        title: {
            display: true,
            text: '',
        }
    }
});
</script>
</html>