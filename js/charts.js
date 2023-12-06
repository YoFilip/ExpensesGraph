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