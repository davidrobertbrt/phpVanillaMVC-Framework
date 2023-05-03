<?php
require_once '../app/core/Model.php';
require_once 'WeatherModel.php';

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

    public function getById($id)
    {
        $data = parent::readById($this->getTableName(),$id);

        if(!$data)
            return null;
        
        return Weather::loadByParams($data['id'],$data['date'],$data['temperature']);
    }

    public function getByParams($params)
    {
        //@TODO find object from database by other columns
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