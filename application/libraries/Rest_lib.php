<?php

class Rest_lib
{
    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    // check request method
    public function method($allowed_method = 'GET') // set default value to get
    {
        // Validate
        if(!isset($_SERVER['REQUEST_METHOD']) // if not set
            || empty($_SERVER['REQUEST_METHOD']) // or if empty
            || !is_string($_SERVER['REQUEST_METHOD'])) // or if not string
            {
                $this->http_response(405, 'Method Not Allowed', '405 Method Not Allowed');
            }

        // Sanitize
        $method = trim(strip_tags($_SERVER['REQUEST_METHOD']));

        // Escape
        $safe_method = (string)$method;

        // check if allowed
        if($method === $allowed_method)
        {
            return true;
        }

        $this->http_response(405, 'Method Not Allowed', '405 Method Not Allowed');
    }

    public function http_response($status, $statusText, $response)
    {
        // Validate
        if(!isset($status) || empty($status) || !is_int($status)
            || !isset($statusText) || empty($statusText) || !is_int($statusText))
        {
            die('wrong data');
        }

        // Sanitize
        $status = trim(strip_tags($status)); // This would be considered safe data (none-tainted)
        $statusText = trim(strip_tags($statusText)); // Also safe now

        // Escape
        $safe_http_status = sprintf('HTTP/1.1 %d %s'
            , (int)$status
            , (string)$statusText);

        if(is_string($response) || is_object($response) || is_array($response) || is_bool($response) || is_int($response))
        {
            $this->ci->output
                ->set_header($safe_http_status)
                ->set_header('Content-Type: application/json')
                ->set_output(json_encode($response))
                ->_display();

            die();
        }

        die('wrong data');
    }
}
