// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages': ['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart() {

    axios.get('/graph/totalsByMonth')
        .then(function (response) {
            // handle success
            // console.log(response.data);
            // Create the data table.
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable(response.data);

                var options = {
                    title: 'Income & Expenditure from past year',
                    curveType: 'function',
                    legend: {position: 'bottom'},
                    series: {
                        0: {targetAxisIndex: 0},
                        1: {targetAxisIndex: 1},
                        2: {targetAxisIndex: 0}
                    },
                    vAxes: {
                        // Adds titles to each axis.
                        0: {
                            title: 'Income',
                            direction: 1,
                            format: 'currency'
                        },
                        1: {
                            title: 'Expenditure',
                            direction: -1,
                            format: 'currency'
                        },
                        2: {
                            title: 'Delta',
                            direction: 1,
                            format: 'currency'
                        }
                    },
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(data, options);
            }
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });

}
