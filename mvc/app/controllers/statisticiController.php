<?php

/**https://canvasjs.com/php-charts/column-chart/
 * link extrem de util si de important
 * bun pentru crearea de grafice
 * aici ii doar i reprezentare bruta a unui bar-chart
 */

include_once "../models/dataBarChart.php";
include_once "../models/dataGraphic.php";

class statisticiController
{
    public  $dataPoints = array();
    public $dataGraphic = array();
    public  function __construct()
    {
        switch($_GET['tipRedare']){
            case 'barChart':{
                $this->dataBarChartStats();
                break;
            }
            case 'grafic2D':{
                //https://apexcharts.com/javascript-chart-demos/line-charts/data-labels/
                $this->dataGraphicStats();
                break;
            }
            case 'tabel':{
                //$obs=["text"=>"nope"];
                //echo json_encode($obs);
                break;
            }
        }
    }
    public function dataBarChartStats()
    {
        $this->dataPoints = DataBarChart::getData($_GET);
        echo  json_encode($this->dataPoints, JSON_NUMERIC_CHECK);
    }
    public function dataGraphicStats(){
        $this->dataGraphic= DataGraphic::getData($_GET);
        echo json_encode($this->dataGraphic);
    }
}
$dataStats = new statisticiController();
