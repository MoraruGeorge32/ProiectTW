<?php
class mapController extends Controller
{
    public function index()
    {
        $dataMap = "SELECT eventid, 
        iyear, 
        imonth,
        iday,
        country_txt,
        region_txt, 
        latitude, 
        longitude, 
        summary, 
        attacktype1_txt, 
        targtype1_txt, 
        gname, 
        nperps, 
        weaptype1_txt, 
        weapsubtype1_txt, 
        nkill, 
        nwound FROM terro_events";
        if (isset($_GET['filters']))
            $dataMap = $dataMap . " WHERE ";
        if (isset($_GET['region'])) {
            $dataMap = $dataMap . "region_txt='" . $_GET['region'] . "'";
        }
        if (isset($_GET['period'])) {
            $period = explode(',', $_GET['period']);
            $dataMap = $dataMap . " AND iyear>=" . $period[0] . " AND iyear<=" . $period[1];
        }
        if (isset($_GET['nwound'])) {
            $wound = explode(',', $_GET['nwound']);
            $dataMap = $dataMap . " AND nwound>=" . $wound[0] . " AND nwound<=" . $wound[1];
        }
        if (isset($_GET['nkill'])) {
            $kill = explode(',', $_GET['nkill']);
            $dataMap = $dataMap . " AND nkill>=" . $kill[0] . " AND nkill<=" . $kill[1];
        }
        if (isset($_GET['success'])) {
            $dataMap = $dataMap . " AND success=" . $_GET['success'];
        }

        if (isset($_GET['suicide'])) {
            $dataMap = $dataMap . " AND suicide=" . $_GET['suicide'];
        }

        if (isset($_GET['exceeded'])) {
            $dataMap = $dataMap . " AND extended=" . $_GET['exceeded'];
        }
        if (isset($_GET['attacktype1'])) {
            $dataMap = $dataMap . " AND attacktype1=" . $_GET['attacktype1'];
        }
        $dataMap = $dataMap . ";";
        $model = $this->model("mapModel");
        $dataArray = $model->mapEvent($dataMap);
        echo json_encode($dataArray);
    }
}
