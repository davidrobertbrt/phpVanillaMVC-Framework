<?php

require_once '../app/models/WeatherModel.php';

class WeatherController extends Controller{
    public function show()
    {
        $weatherModel = new weatherModel();
        $weatherList = $weatherModel->getAll();
        print_r($weatherList);
        $this->render('WeatherShow',$weatherList);
    }
}