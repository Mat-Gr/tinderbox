<?php

class User_lib
{
    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();

        // load user_model
        $this->ci->load->model('user_model');

    }

    public function authorize() // check user credentials
    {
        // Validate
        if(!isset(getallheaders()['Authorization']) // if authorization not set
            || empty(getallheaders()['Authorization']) // or is empty
            || !is_string(getallheaders()['Authorization'])) // or is not a string
        {
            $this->ci->rest_lib->http_response(401, 'Unauthorized', 'Incorrect authorization');
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

        $res = $this->ci->user_model->login_user($safe_email, $safe_password);

        if ($res === false)
        {
            $this->ci->rest_lib->http_response(401, 'Unauthorized', 'Username or password is wrong');
        }
        return $res;

    }

    public function get_userinfo($token)
    {
        $res = $this->ci->user_model->get_userinfo($token);

        if($res === false)
        {
            $this->ci->rest_lib->http_response(500, 'Internal Server Error', 'Something went wrong');
        }
        return $res;
    }

}
