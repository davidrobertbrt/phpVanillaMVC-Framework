<?php
class ExampleModel
{
    private string $property;

    public function __construct()
    {
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function setProperty(string $property)
    {
        $this->property = $property;
    }

}