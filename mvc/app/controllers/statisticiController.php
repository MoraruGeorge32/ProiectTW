<?php
/**https://canvasjs.com/php-charts/column-chart/
 * link extrem de util si de important
 * bun pentru crearea de grafice
 * aici ii doar i reprezentare bruta a unui bar-chart
*/

$numartari = $_GET['numarTari'];
$contor = 1;
$dataPoints = array();
$mysqlConnect = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
$rez = array();

$stmt = $mysqlConnect->prepare("select sum(cast(nkill as unsigned)) from terro_events where country_txt=?");
for ($contor = 1; $contor <= $numartari; $contor++) {
    $currentCountry = $_GET['tara' . $contor];
    $stmt->bind_param("s", $currentCountry);
    $stmt->execute();
    $countKills = 0;
    $stmt->bind_result($countKills);
    $stmt->fetch();
    $rez[$currentCountry] = $countKills;
}


for ($contor = 1; $contor <= $numartari; $contor++) {
    $currentCountry = $_GET['tara' . $contor];
    array_push($dataPoints, array("y" => $rez[$currentCountry], "label" => $currentCountry));
}
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
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
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