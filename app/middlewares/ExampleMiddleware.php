<?php
class ExampleMiddleware implements Middleware{
    public function __invoke($data){
        echo("Example middleware invoked!");
        return $data;
    }
}