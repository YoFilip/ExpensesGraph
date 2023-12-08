<<<<<<< HEAD
var options = {
    series: [{
        name: 'PRODUCT A',
        data: [44, 55, 41, 67, 22, 43, 34]
    }, {
        name: 'PRODUCT B',
        data: [13, 23, 20, 8, 13, 27, 21]
    }, {
        name: 'PRODUCT C',
        data: [11, 17, 15, 15, 21, 14, 45]
    }, {
        name: 'PRODUCT D',
        data: [21, 7, 25, 13, 22, 8, 79]
    }],
    chart: {
        type: 'line',
        height: 350,
        stacked: true,
        toolbar: {
            show: true
        },
        zoom: {
            enabled: true
        }
    },
    responsive: [{
        breakpoint: 480,
        options: {
            legend: {
                position: 'bottom',
                offsetX: -10,
                offsetY: 0
            }
        }
    }],
    plotOptions: {
        bar: {
            horizontal: false,
            borderRadius: 10,
            dataLabels: {
                total: {
                    enabled: true,
                    style: {
                        fontSize: '13px',
                        fontWeight: 900
                    }
                }
            }
        },
    },
    xaxis: {
        type: 'datetime',
        categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
            '01/05/2011 GMT', '01/06/2011 GMT', '01/07/2011 GMT'
        ],
    },
    legend: {
        position: 'right',
        offsetY: 40
    },
    fill: {
        opacity: 1
    }
};

var chart = new ApexCharts(document.querySelector("#myChart"), options);
chart.render();
=======
var ctx = document.getElementById('myChart').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            datasets: [{ 
                data: [86,114,106,106,107,111,133],
                label: "Total",
                borderColor: "rgb(62,149,205)",
                backgroundColor: "rgb(62,149,205,0.1)",
              }, { 
                data: [70,90,44,60,83,90,100],
                label: "Accepted",
                borderColor: "rgb(60,186,159)",
                backgroundColor: "rgb(60,186,159,0.1)",
              }, { 
                data: [10,21,60,44,17,21,17],
                label: "Pending",
                borderColor: "rgb(255,165,0)",
                backgroundColor:"rgb(255,165,0,0.1)",
              }, { 
                data: [6,3,2,2,7,0,16],
                label: "Rejected",
                borderColor: "rgb(196,88,80)",
                backgroundColor:"rgb(196,88,80,0.1)",
              }
            ]
          },
        });

        
>>>>>>> 144d856dbf825e8a904dca03dbd1eb017c98112f
