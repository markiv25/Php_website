<?php

class Events{
    private $idevent;
    private $name;
    private $datestart;
    private $dateend;
    private $numberallowed;
    private $venue;
   
    
    
    private $event = array();

    public function whoAmI(){

        $event['idevent']=$this->idevent;
        $event['name']=$this->name;
        $event['datestart']=$this->datestart;
        $event['dateend']=$this->dateend;
        $event['numberallowed']=$this->numberallowed;
        $event['venue']=$this->venue;
        $event['venue_name']=$this->venue_name;
        
        return $event ;
    }
}

?>