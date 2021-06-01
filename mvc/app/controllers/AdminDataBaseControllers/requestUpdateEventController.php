<?php
include_once "../../core/Controller.php";
include_once "../../models/AdminDataBase/list_update.php";

class requestListUpdateEvent extends Controller{
    public function page_nr(){
        $get_events = new listUpdateEvent();
        return $get_events->getListFromDb($_GET['page']);
    }
}

$upd = new requestListUpdateEvent();
echo $upd->page_nr();

?>
