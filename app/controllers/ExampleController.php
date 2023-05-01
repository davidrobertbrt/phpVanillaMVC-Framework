<?php

class ExampleController extends Controller
{
    public function index()
    {
        $this->view('ExampleView');
    }

    public function modelview()
    {
        $modelExample = $this->model("ExampleModel");
        $modelExample->setProperty("Data from the model example.");
        $this->view('ExampleModelView',array('property'=>$modelExample->getProperty()));
    }
}