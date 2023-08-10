(function () {
    const graphic = document.querySelector('#gifts-graphic')

    if(graphic) {
        getData();
        async function getData() {
            const url = '/api/gifts'
            const response = await fetch(url);
            const result = await response.json();


            const ctx = document.getElementById('gifts-graphic');

            new Chart(ctx, {
              type: 'bar',
              data: {
                labels: result.map(gift => gift.name),
                datasets: [{
                  label: '',
                  data: result.map(gift => gift.total),
                  backgroundColor: [
                    '#ea580c',
                    '#84cc16',
                    '#22d3ee',
                    '#a855f7',
                    '#ef4444',
                    '#14b8a6',
                    '#db2777',
                    '#e11d48',
                    '#7e22ce'
                ],
                  borderWidth: 1
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
              }
            });
        }
    }


})();