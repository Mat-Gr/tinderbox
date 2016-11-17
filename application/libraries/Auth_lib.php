<?php

class Auth_lib
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

    public function authorize() // check user credentials
    {
        // Validate
        if(!isset(getallheaders()['Authorization']) // if authorization not set
            || empty(getallheaders()['Authorization']) // or is empty
            || !is_string(getallheaders()['Authorization'])) // or is not a string
        {
            $this->http_response(401, 'Unauthorized', 'Incorrect authorization');
        }

        // Sanitize
        $basic_auth = trim(strip_tags(getallheaders()['Authorization']));

        // Escape
        $basic_auth = (string)$basic_auth;
        $encoded_login = explode(' ', $basic_auth)[1];
        $decoded_login = base64_decode($encoded_login);
        $credentials = explode(':', $decoded_login);

        // Resecure the decoded credentials
        // Sanitize & Escape
        $email = trim(strip_tags($credentials[0]));
        $safe_email = (string)$email;

        $password = trim(strip_tags($credentials[1]));
        $safe_password = (string)$password;

        // load user_model
        $this->ci->load->model('user_model');

        $res = $this->ci->user_model->login_user($safe_email, $safe_password);

        if ($res === false)
        {
            $this->http_response(401, 'Unauthorized', 'Username or password is wrong');
        }
        return true;

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
