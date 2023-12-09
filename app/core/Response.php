<?php

/**
 * Response Class
 * 
 * This class represents an HTTP response and provides methods to set the
 * status code, content, and headers. It also includes additional methods for
 * common response scenarios such as sending JSON or HTML content.
 * 
 * @final
 */

final class Response
{
    private $statusCode;
    private $content;
    private $headers;

    public function __construct($content, $statusCode = 200, $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->headers = $headers;
    }

    public function send()
    {
        // Set HTTP status code
        http_response_code($this->statusCode);
        
        // Set headers
        if(count($this->headers) > 0){
            $this->setHeaders();
        }

        // Output content
        if (isset($this->content)) {
            echo $this->content;
        }
    }

    private function setHeaders()
    {
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    // Additional methods for common response scenarios

    public function sendJson()
    {
        $this->addHeader('Content-Type', 'application/json');
        $this->send();
    }

    public function sendHtml()
    {
        $this->addHeader('Content-Type', 'text/html');
        $this->send();
    }
}
