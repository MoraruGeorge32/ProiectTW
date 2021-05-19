<?php

/**https://canvasjs.com/php-charts/column-chart/
 * link extrem de util si de important
 * bun pentru crearea de grafice
 * aici ii doar i reprezentare bruta a unui bar-chart
 */

 include_once "../models/dataBarChart.php";

class statisticiController
{
    public  $dataPoints = array();
    public  function index()
    {
        
        $this->dataPoints = DataBarChart::getData($_GET);
    }
}

$dataStats = new statisticiController();
$dataStats->index();
?>
<!DOCTYPE HTML>
<html>

<head>
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Grafic numar decese in total"
                },
                axisY: {
                    title: "Numar omoruri"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## kills",
                    dataPoints: <?php echo json_encode($dataStats->dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>

s