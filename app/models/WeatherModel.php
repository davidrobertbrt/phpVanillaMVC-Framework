<?php
require_once '../app/core/Model.php';
require_once 'Weather.php';

class WeatherModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName()
    {
        return 'weather';
    }

    public function getAll()
    {
        $weatherList = array();
        $dataList = parent::readAll($this->getTableName());

        foreach ($dataList as $data) {
            $weatherList[] = Weather::loadByParams($data['id'], $data['date'], $data['temperature']);
        }

        return $weatherList;
    }

    public function getById($id)
    {
        $data = parent::readById($this->getTableName(),$id);

        if(!$data)
            return null;
        
        return Weather::loadByParams($data['id'],$data['date'],$data['temperature']);
    }

    public function getByParams($params)
    {
        $data = parent::readyByParams($this->getTableName(),$params);
        
        if(!$data)
            return null;
        
        $results = array();

        foreach($data as $row)
            $results[] = Weather::loadByParams($row['id'],$row['date'],$row['temperature']);
        
        if(count($results) === 1)
            return $results[0];
        else
            return $results;
    }


    public function save(Weather $weather)
    {
        $data = array(
            'date'=>$weather->getDate(),
            'temperature'=>$weather->getTemperature()
        );

        if($weather->getId())
        {
            return parent::update($this->getTableName(),$data,$weather->getId());
        }
        else{
            $id = parent::insert($this->getTableName(),$data);
            $weather->setId($id);
            return true;
        }
    }

    public function deleteById($id)
    {
        return parent::delete($this->getTableName(),$id);
    }
}