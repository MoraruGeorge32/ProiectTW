<?php

/**https://canvasjs.com/php-charts/column-chart/
 * link extrem de util si de important
 * bun pentru crearea de grafice
 * aici ii doar i reprezentare bruta a unui bar-chart
 */

include_once "../models/dataBarChart.php";
include_once "../models/dataGraphic.php";
include_once "../models/scatterDataChart.php";

class statisticiController
{
    public $dataPoints = array();
    public $dataGraphic = array();
    public $dataArea = array();
    public $numarlocatii = 0;
    public $columnLocation = "";
    public $columnSearchedValues = "";
    public  function __construct()
    {
        if (isset($_GET['numarTari'])) {
            $this->numarlocatii = $_GET['numarTari'];
            $this->columnLocation = "country_txt";
        } else if (isset($_GET['numarRegiuni'])) {
            $this->numarlocatii = $_GET['numarRegiuni'];
            $this->columnLocation = "region_txt";
        }
        if ($_GET['numarRedari'] == 1) {
            if (isset($_GET['numarRaniti']))
                $this->columnSearchedValues = "numarRaniti";
            if (isset($_GET['numarDecese']))
                $this->columnSearchedValues = "numarDecese";
            if (isset($_GET['numarAtacuri']))
                $this->columnSearchedValues = "numarAtacuri";
            switch ($_GET['tipRedare']) {
                case 'barChart': {
                        $this->dataBarChartStats();
                        break;
                    }
                case 'grafic2D': {
                        //https://apexcharts.com/javascript-chart-demos/line-charts/data-labels/
                        $this->dataGraphicStats();
                        break;
                    }
                case 'scatter': {
                        $this->dataScatter();
                        break;
                    }
            }
        }
        else
            echo "RAmane de implementat pentru o tara si mai multe statistici";
    }
    public function dataScatter()
    {
        $this->dataPolarArea = DataScatter::getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        echo json_encode($this->dataPolarArea, JSON_NUMERIC_CHECK);
    }
    public function dataBarChartStats()
    {
        $this->dataPoints = DataBarChart::getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        echo  json_encode($this->dataPoints, JSON_NUMERIC_CHECK);
    }
    public function dataGraphicStats()
    {
        $this->dataGraphic = DataGraphic::getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        echo json_encode($this->dataGraphic);
    }
}
$dataStats = new statisticiController();
