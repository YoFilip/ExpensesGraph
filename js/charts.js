new Chart(document.getElementById("myChart"), {
    type : 'line',
    data : {
        labels : [ 1500, 1600, 1700, 1750, 1800, 1850,
                1900, 1950, 1999, 2050,1500, 1600, 1700, 1750, 1800, 1850,
                1900, 1950, 1999, 2050,1500, 1600, 1700, 1750, 1800, 1850,
                1900, 1950, 1999, 2050 ],
        datasets : [
                {
                    data : [ 186, 205, 1321, 1516, 2107,
                            2191, 3133, 3221, 4783, 5478,186, 205, 1321, 1516, 2107,
                            2191, 3133, 3221, 4783, 5478, ],
                    label : "America",
                    borderColor : "#3cba9f",
                    fill : false
                },
                {
                    data : [
                        2191, 3133, 3221, 4783, 5478,186, 205, 1321, 1516, 2107,
                        2191, 3133, 3221, 4783, 5478,  ],
                    label : "Europe",
                    borderColor : "#e43202",
                    fill : false
                } ]
    },
    options : {
        title : {
            display : true,
            text : '' //Nazwa żeby nie zapomnieć
        }
    }
});