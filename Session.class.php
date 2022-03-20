<?php  



class Session{
    private $numberallowed;
    private $name;
    private $idsession;
    private $evnt;
    private $enddate;
    private $startdate;


    private $event = array();

    public function sess(){

        $event['name']=$this->name;
        $event['numberallowed']=$this->numberallowed;
        $event['idsession']=$this->idsession;
        $event['evnt']=$this->evnt;
        $event['enddate']=$this->enddate;
        $event['startdate']=$this->startdate;

        return $event ;
    }




}




?>