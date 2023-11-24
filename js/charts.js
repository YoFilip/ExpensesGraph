


const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['20.11.2023', '21.11.2023', '22.11.2023', '23.11.2023', '24.11.2023', '25.11.2023', '26.11.2023', '26.10.2023'],
        datasets: [{
            label: '# of Votes',
            data: [12, 12, 20, 5, 2, 3, 20, 20],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});