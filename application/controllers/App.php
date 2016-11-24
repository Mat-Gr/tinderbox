<?php

class App extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('rest_lib', 'user_lib'));
    }

    public function schedule() //load schedule
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $token = $this->user_lib->authorize();

        // get userinfo (id or token needed to fetch unique users schedule)

        // set output with schedule_model
        $this->load->model('schedule_model');

        $model_res = $this->schedule_model->get_schedule($token);

        $this->rest_lib->http_response(200, 'OK', $model_res);

    }

    public function announcements() //load announcements
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $this->user_lib->authorize();

        $this->load->model('announcement_model');

        $pinned = $this->announcement_model->get_pinned();
        $announcements = $this->announcement_model->get_ann();

        $pinned->pinned = 'true';
        $result = $announcements;
        array_unshift($result, $pinned);

        return $this->rest_lib->http_response(200, 'OK', $result);
    }

    public function userinfo() //load userinfo
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $token = $this->user_lib->authorize();
        $userinfo = $this->user_lib->get_userinfo($token);

        $this->rest_lib->http_response(200, 'OK', $userinfo);
    }

    public function signup()
    {
        $this->rest_lib->method('POST');

        //file contents....
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

        $res = $this->user_model->set_user([
            'fname' => $secured->fname,
            'lname' => $secured->lname,
            'email' => $secured->email,
            'password' => $secured->password,
            'birthdate' => $secured->birthdate,
            'phone' => $secured->phone,
            'shirt_size' => $secured->shirt_size,
            'shoe_size' => $secured->shoe_size
        ]);

        if(!($res === false) && is_string($res))
        {
            $this->rest_lib->http_response(200, 'OK', $res);  // change this -- don't return id to user
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

        $res = $this->user_model->edit_user($token, [
            'password' => $secured->password,
            'phone' => $secured->phone,
            'shirt_size' => $secured->shirt_size,
            'shoe_size' => $secured->shoe_size,
        ]);

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

        // Validate      
        if(!is_string($token))
        {
            $this->rest_lib->http_response(400, 'Bad Request', 'Wrong data');
        }


        // Sanitize

        $model_res = $this->user_model->delete_user($token);

        if($model_res === true)
        {
            $this->rest_lib->http_response(200, 'OK', 'User Deleted');
        }
        $this->rest_lib->http_response(500, 'Internal Server Error', 'Something went wrong');

    }
}
