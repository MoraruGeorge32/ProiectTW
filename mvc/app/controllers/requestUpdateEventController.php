<?php
class requestUpdateEventController extends Controller{
    public function page_nr(){
        $get_events = $this->model('listUpdateEvent');
        echo $get_events->getListFromDb($_GET['page']);
    }
}

