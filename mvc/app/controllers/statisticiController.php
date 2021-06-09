<?php

class StatisticiController extends Controller
{
    public $dataPoints = array();
    public $dataGraphic = array();
    public $dataArea = array();
    public $numarlocatii = 0;
    public $columnLocation = "";
    public $columnSearchedValues = "";
    public  function index()
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
        } else {
            // am o tara si vreau mai multe statistici pentru ea
            if ($this->numarlocatii == 1) {
                $coloaneValori = [];
                if (isset($_GET['numarRaniti']))
                    array_push($coloaneValori, "sum(nwound)");
                if (isset($_GET['numarDecese']))
                    array_push($coloaneValori, "sum(nkill)");
                if (isset($_GET['numarAtacuri']))
                    array_push($coloaneValori, "count(*)");
                switch ($_GET['tipRedare']) {
                    case 'barChart': {

                            $model = $this->model("DataBarChart");                                  //country sau region    coloane ca de ex sum(nkill) sau sum(wound) sau count(*)
                            $this->dataPoints = $model->getDataSingleLocationMultipleColumns($_GET, $this->columnLocation, $coloaneValori);
                            echo  json_encode($this->dataPoints, JSON_NUMERIC_CHECK);
                            break;
                        }
                    case 'grafic2D': {
                            $model = $this->model("DataGraphic");
                            $this->dataGraphic = $model->getDataSingleLocationMultipleColumns($_GET, $this->columnLocation, $coloaneValori);
                            echo json_encode($this->dataGraphic, JSON_NUMERIC_CHECK);
                            break;
                        }
                    case 'scatter': {
                            $model = $this->model("DataScatter");
                            $this->dataGraphic = $model->getDataSingleLocationMultipleColumns($_GET, $this->columnLocation, $coloaneValori);
                            echo json_encode($this->dataGraphic, JSON_NUMERIC_CHECK);
                            break;
                        }
                }
            } else
                echo "Nu se poate face grafic cu mai multe tari/regiuni si mai multe filtre";
        }
    }
    public function dataScatter()
    {
        //$this->dataPolarArea = DataScatter::getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        $model = $this->model("DataScatter");
        $this->dataArea = $model->getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        echo json_encode($this->dataArea, JSON_NUMERIC_CHECK);
    }
    public function dataBarChartStats()
    {
        //$this->dataPoints = DataBarChart::getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        $model = $this->model("DataBarChart");
        $this->dataPoints = $model->getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        echo  json_encode($this->dataPoints, JSON_NUMERIC_CHECK);
    }
    public function dataGraphicStats()
    {
        //$this->dataGraphic = DataGraphic::getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        $model = $this->model("DataGraphic");
        $this->dataGraphic = $model->getData($_GET, $this->numarlocatii, $this->columnLocation, $this->columnSearchedValues);
        echo json_encode($this->dataGraphic);
    }
}
