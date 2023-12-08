document.addEventListener('DOMContentLoaded', function () {
    if (typeof expensesData === 'undefined') {
        return;
    }

    var seriesData = Object.keys(expensesData).map(function (key) {
        return {
            name: key,
            data: expensesData[key]
        };
    });

    var options = {
        series: seriesData,
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: seriesData.length > 0 ? seriesData[0].data.map(function (d) { return d.x; }) : [],
            type: 'datetime'
        },
        yaxis: {
            title: {
                text: 'Kwota (zł)'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " zł"
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#myChart"), options);
    chart.render();
});
