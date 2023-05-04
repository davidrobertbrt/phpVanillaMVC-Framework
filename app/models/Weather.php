<?php

class Weather{
    private $id;
    private $date;
    private $temperature;

    public function __construct()
    {

    }

    public static function loadByParams($id,$date,$temperature)
    {
        $instance = new Weather();
        $instance->id = $id;
        $instance->date = $date;
        $instance->temperature = $temperature;
        return $instance;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function setTemperature($temperature)
    {
        $this->temperature =  $temperature;
    }
}