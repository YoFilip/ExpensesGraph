<?php
require_once "config.php";
// session_start();

$query = "SELECT title FROM categories";
$result = $conn->query($query);

$categories = array();

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['title'];
}

// TODO:
// $query = "SELECT amount, date FROM expenses WHERE expenses.id = categories.expense_id AND $_SESSION['id'] = expenses.user_id";

$query = "SELECT c.categorie_id, e.amount, e.date, c.title FROM expenses e, categories c WHERE e.expense_id = c.categorie_id";

$res = $conn->query($query);

$data = [];
$dates = [];
$titles = [];
$d1 = [];
while($row = $res->fetch_assoc())
{
    $data = [...$data, $row['amount']];
    $titles = [...$titles, $row['title']];
    $d1 = [...$d1, $row['date']=>$row['amount']];
}
ksort($d1);

$date_var = array_keys($d1);

for($i = 0; $i < sizeof($d1); ++$i)
{
    $dates = [...$dates, $d1[$date_var[$i]]];
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    var data = <?php echo json_encode($data);?>;

    var dates = <?php echo json_encode($dates);?>;

    var titles = <?php echo json_encode($titles);?>;

    var datasets = [];
    
    for (var i = 0; i < categories.length; i++) {
        var dataset = {
            data: data,
            label: titles[i],
            borderColor: getRandomColor(),
            fill: false
        };
        datasets.push(dataset);
    }

    new Chart(document.getElementById("myChart"), {
        type: 'line',
        data: {
            labels: dates,
            datasets: datasets 
        },
        options: {
            title: {
                display: true,
                text: 'Wydatki'
            }
        }
    });

    function getRandomColor()
    {
        let options = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F'];

        let color = "#";

        while(color.length < 7)
        {
            color += options[Math.floor(Math.random() * 16)]
        }
        return color;
    }


    // var categories = <?php// echo json_encode($categories); ?>;
    // var datasets = [];
    // for(var i = 0; i < categories.length; ++i)
    // {
    //     var dataset = [
    //         {
    //             data: [10],
    //             label: categories[i],
    //             borderColor: "#3e95cd",
    //             fill: false
    //         }
    //     ]
    //     datasets.push(dataset);
    // }
    
    // new Chart(document.getElementById("myChart"), {
    // type: 'line',
    // data: {
    //     labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050, 1999, 2050,],
    //     datasets: datasets,
        // {
        //     data: [282, 350, 411, 502, 635, 809, 947, 1402, 3700, 5267],
        //     label: categories[1],
        //     borderColor: "#8e5ea2",
        //     fill: false
        // }, {
        //     data: [168, 170, 178, 190, 203, 276, 408, 547, 675, 734],
        //     label: categories,
        //     borderColor: "#3cba9f",
        //     fill: false
        // }, {
        //     data: [40, 20, 10, 16, 24, 38, 74, 167, 508, 784],
        //     label: categories,
        //     borderColor: "#e8c3b9",
        //     fill: false
        // }, {
        //     data: [6, 3, 2, 2, 7, 26, 82, 172, 312, 433],
        //     label: categories,
        //     borderColor: "#c45850",
        //     fill: false
        // }
        // ]
//     },
//     options: {
//         title: {
//             display: true,
//             text: '',
//         }
//     }
// });
</script>
</html>