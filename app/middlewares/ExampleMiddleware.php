<?php
final class ExampleMiddleware implements Middleware{
    public function __invoke($req){
        echo("Example middleware invoked!");
        return $req;
    }
}