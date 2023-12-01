new Chart(document.getElementById("myChart"), {
    type: 'line',
    data: {
        labels: ['2023-12-04', '2023-12-05', '2023-12-06', '2023-12-07', '2023-12-12', '2023-12-13', '2023-12-14', '2023-12-15', '2023-12-18', '2023-12-19', '2023-12-21', '2023-12-22', '2023-12-25', '2023-12-26', '2023-12-27', '2023-12-29'],
        datasets: [
            {
                data: [52, 101, 108, 131, 251, 284, 296, 329, 335, 373, 377, 386, 410, 446, 467],
                label: "Dom",
                borderColor: "#3cba9f",
                fill: false,
            },
            {
                data: [42, 94, 179, 180, 321, 403, 409, 497, 502, 538, 566, 582, 587, 613, 638, 666],
                label: "Dzieci",
                borderColor: "#e43202",
                fill: false,
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "WYKRES WYDATKÓW",
        },
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            zoom: {
                pan: {
                    enabled: true,
                    mode: 'x',
                    rangeMax: {
                        x: 100000,
                    },
                    rangeMin: {
                        x: 1750,
                    },
                },
                zoom: {
                    enabled: true,
                    mode: 'xy',
                    rangeMax: {
                        x: 10000,
                    },
                    rangeMin: {
                        x: 1750,
                    },
                },
            },
        },
    },
});




