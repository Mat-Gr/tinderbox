<?php

class App extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('rest_lib', 'user_lib'));
    }

    public function schedule()
    {
        $this->rest_lib->method('GET');
        $token = $this->user_lib->authorize();

        $this->load->model('schedule_model');
        $model_res = $this->schedule_model->get_schedule($token);

        if($model_res === false)
        {
            $this->rest_lib->http_response(204, 'No Content', 'No schedule');
        }
        $this->rest_lib->http_response(200, 'OK', $model_res);
    }

    public function announcements()
    {
        $this->rest_lib->method('GET');
        $this->user_lib->authorize();

        $this->load->model('announcement_model');
        $pinned = $this->announcement_model->get_pinned();
        $announcements = $this->announcement_model->get_ann();
        $result = $announcements;

        if(!empty($pinned))
        {
            $pinned->pinned = 'true';
        }
        if(!is_null($pinned))
        {
            array_unshift($result, $pinned);
        }

        if(empty($result))
        {
            return $this->rest_lib->http_response(204, 'No Content', 'No announcements');
        }
        return $this->rest_lib->http_response(200, 'OK', $result);
    }

    public function userinfo()
    {
        $this->rest_lib->method('GET');
        $token = $this->user_lib->authorize();
        $userinfo = $this->user_lib->get_userinfo($token);

        if($userinfo === false)
        {
            $this->rest_lib->http_response(500, 'Internal Server Error', 'Something went wrong');
        }
        $this->rest_lib->http_response(200, 'OK', $userinfo);
    }

    public function signup()
    {
        $this->rest_lib->method('POST');

        $post = file_get_contents('php://input');
        $post = json_decode($post);

        // Validate
        $req = [
            'fname',
            'lname',
            'email',
            'password',
            'birthdate',
            'phone',
            'shirt_size',
            'shoe_size'
        ];

        if(!is_object($post) || $this->sec_lib->validate($post, $req) === false)
        {
            $this->rest_lib->http_response(400, 'Bad Request', 'Wrong data');
        }

        // Sanitize & escape
        $secured = $this->sec_lib->secure($post);
        $this->load->model('user_model');

        $data = new stdClass;
        $data = (object)[
            'fname' => $secured->fname,
            'lname' => $secured->lname,
            'email' => $secured->email,
            'password' => $secured->password,
            'birthdate' => $secured->birthdate,
            'phone' => $secured->phone,
            'shirt_size' => $secured->shirt_size,
            'shoe_size' => $secured->shoe_size
        ];

        $res = $this->user_model->set_user($data);

        if(!($res === false) && is_string($res))
        {
            $this->rest_lib->http_response(200, 'OK', $res);
        }
        $this->rest_lib->http_response(500, 'Internal Server Error', 'Something went wrong');
    }

    public function edit_user()
    {
        $this->rest_lib->method('PUT');

        // check user credentials in database with User-lib
        $token = $this->user_lib->authorize();

        //file contents....
        $put = file_get_contents('php://input');
        $put = json_decode($put);

        // Validate
        $req = [
            'password',
            'phone',
            'shirt_size',
            'shoe_size'
        ];

        if(!is_object($put) || $this->sec_lib->validate($put, $req) === false)
        {
            $this->rest_lib->http_response(400, 'Bad Request', 'Wrong data');
        }

        // Sanitize
        $secured = $this->sec_lib->secure($put);
        $this->load->model('user_model');

        $data = new stdClass;
        $data = (object)[
            'password' => $secured->password,
            'phone' => $secured->phone,
            'shirt_size' => $secured->shirt_size,
            'shoe_size' => $secured->shoe_size,
        ];

        $res = $this->user_model->edit_user($token, $data);

        if($res === true)
        {
            $this->rest_lib->http_response(200, 'OK', 'Updated successfully');
        }
        $this->rest_lib->http_response(500, 'Internal Server Error', 'Something went wrong');
    }

    public function delete_user()
    {
        $this->rest_lib->method('DELETE');
        $token = $this->user_lib->authorize();

        if(empty($token) || !is_string($token))
        {
            return false;
        }
        $token = (string)trim(strip_tags($token));

        $model_res = $this->user_model->delete_user($token);

        if($model_res === true)
        {
            $this->rest_lib->http_response(200, 'OK', 'User Deleted');
        }
        $this->rest_lib->http_response(500, 'Internal Server Error', 'Something went wrong');

    }
}
