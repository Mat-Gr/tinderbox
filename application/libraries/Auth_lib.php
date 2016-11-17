<?php

class Auth_lib
{
    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function method() // check request method
    {

    }

    public function authorize() // check user credentials
    {

    }

    public function http_response($status, $statusText, $response)
    {
        // Validate
        if(!is_int($status))
        {
            die('wrong data');
        }

        if(!is_string($statusText))
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
