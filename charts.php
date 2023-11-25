<?php
require_once "config.php";

$query = "SELECT content FROM categories";
$result = $conn->query($query);

$categories = array();

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['content'];
}
// TODO:
// $query = "SELECT amount FROM expenses WHERE expenses.id = categories.expense_id "

// $query = "INSERT INTO categories(expense_id, content) VALUES(1, 'umiejętności artura')";
// $query1 = "INSERT INTO categories(expense_id, content) VALUES(1, 'umiejętności ar1tura')";
// $query2= "INSERT INTO categories(expense_id, content) VALUES(1, 'umiejętno1ści artura')";
// $query3 = "INSERT INTO categories(expense_id, content) VALUES(1, 'umiejętności ar3tura')";

// $conn->query($query);
// $conn->query($query1);
// $conn->query($query2);
// $conn->query($query3);

$conn->close();
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
    
    const colors = ["red", "blue", "green", "yellow", "cyan", "gold"];

    
    var categories = <?php echo json_encode($categories); ?>;

    var datasets = [];

    
    for (var i = 0; i < categories.length; i++) {
        var dataset = {
            data: [10,20,30,40],
            label: categories[i], 
            borderColor: getRandomColor(), 
            fill: false
        };
        datasets.push(dataset);
    }

    new Chart(document.getElementById("myChart"), {
        type: 'line',
        data: {
            labels: categories,
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

        let  color = "#";

        while(color.length < 8)
        {
            color += options[Math.floor(Math.random() * 16)]
        }
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