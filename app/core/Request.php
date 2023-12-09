<?php
/**
 * Request Parsing Module
 * 
 * This module parses the request URL and returns an associative array containing
 * the controller, action, HTTP method, and request data (GET / POST). The URL is
 * split into an array using the forward slash '/' as a delimiter. The first and
 * second elements of this array are assigned to the $controller and $action variables
 * respectively. The HTTP method is obtained from the $_SERVER['REQUEST_METHOD'] superglobal
 * variable.
 * 
 * The request data is stored in the $requestData array, with GET parameters stored in
 * the 'GET' key and POST parameters stored in the 'POST' key. The GET parameters are obtained
 * from the superglobal variable $_GET if the HTTP method is GET. The POST parameters are obtained
 * from the $_POST superglobal variable if the HTTP method is POST.
 * 
 * The function returns a Request object with the following properties:
 * - descriptor: a string in the format "controller@action", used to map the routes to the handlers @see Mapping.php
 * - method: the HTTP method
 * - params: an associative array containing the GET and POST parameters
 * 
 * @return Request An object containing parsed information about the request.
 * 
 * @throws UnexpectedValueException If the request method is not valid or the descriptor is empty.
 */

final class Request{
    private $descriptor;
    private $method;
    private $params;

    public function __construct($descriptor,$method,$params)
    {
        $this->descriptor = $descriptor;
        $this->method = $method;
        $this->params = $params;
    }

    public static function parse()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if($method !== 'GET' && $method !== 'POST'){
            throw new UnexpectedValueException("The request method is not valid!");
        }

        if(isset($_GET['url']))
        {
            $uri = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
            $controller = $uri[0] ?? null;
            $action = $uri[1] ?? 'index';

            unset($_GET['url']);
        }

        if($method === 'GET')
            $requestParams = $_GET;
        
        if($method === 'POST')
            $requestParams = $_POST;


        if(isset($controller) && isset($action))
            $descriptor = $controller . '@' . $action;
        else
            $descriptor = '@';

        if(!isset($descriptor)){
            throw new UnexpectedValueException("The descriptor can not be empty!");
        }

        return new self($descriptor, $method, $requestParams);
    }

    public function getDescriptor() {
        return $this->descriptor;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getParams() {
        return $this->params;
    }

    public function setParams($params)
    {
        if(is_array($params))
            $this->params = $params;
    }
}