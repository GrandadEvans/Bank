// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart() {

    axios.get('/graph/by-tags/months/6')
        .then(function (response) {
            // handle success
            // console.log(response);
            // Create the data table.
            var data = new google.visualization.DataTable();

            data.addColumn('string', 'Tag');
            data.addColumn('number', 'Popularity');

            data.addRows(response.data);

            // Set chart options
            var options = {
                'title':'Tags Usage in last 6 months',
                'width':300,
                'height':200
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });

}
