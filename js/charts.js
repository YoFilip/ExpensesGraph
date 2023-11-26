new Chart(document.getElementById("myChart"), {
    type: 'line',
    data: {
        labels: [1500, 1600, 1700, 1750, 1800, 1850, 1900, 1950, 1999, 2050,2060,2070,2080,2090,3000,3010,3020,3030],
        datasets: [
            {
                data: [186, 205, 1321, 1516, 2107, 2191, 3133, 3221, 4783, 5478,186, 205, 1321, 1516, 2107, 2191, 3133, 3221, 4783, 5478],
                label: "America",
                borderColor: "#3cba9f",
                fill: false,
            },
            {
                data: [2191, 3133, 3221, 4783, 5478, 186, 205, 1321, 1516, 2107,2191, 3133, 3221, 4783, 5478, 186, 205, 1321, 1516, 2107,],
                label: "Europe",
                borderColor: "#e43202",
                fill: false,
            },
        ],
    },
    options: {
        title: {
            display: true,
            text: "Title",
        },
        scales:{
            y:{
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




