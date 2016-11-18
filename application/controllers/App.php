<?php

class App extends CI_Controller
{
    public function schedule() //load schedule
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $this->user_lib->authorize();

        // get userinfo (id or token needed to fetch unique users schedule)

        // set output with schedule_model
        $this->load->model('schedule_model');

        $model_res = $this->schedule_model->get_schedule();

        if($model_res === true)
        {
            $this->output
                ->set_header('HTTP/1.1 200 OK')
                ->set_header('Content-Type: application/json')
                ->set_output(json_encode([
                    'status' => 200,
                    'statusText' => 'OK',
                    'response' => $model_res
                    ]))
                ->_display();
            die();
        }
    }

    public function announcements() //load announcements
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $this->user_lib->authorize();

        // get userinfo (id or token needed to fetch unique users announcements)


        $this->load->model('announcement_model');

        $model_res = $this->announcement_model->get_ann();

        if($model_res === true)
        {
            $this->output
                ->set_header('HTTP/1.1 200 OK')
                ->set_header('Content-Type: application/json')
                ->set_output(json_encode([
                    'status' => 200,
                    'statusText' => 'OK',
                    'response' => $model_res
                    ]))
                ->_display();
            die();
      }
        // set output with announcements_model
    }

    public function userinfo() //load userinfo
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $this->user_lib->authorize();

        $userinfo = $this->user_lib->get_userinfo();

        $this->rest_lib->http_response(200, 'OK', $userinfo);
    }

    public function signup()
    {
        // check request method with Rest-lib == GET
        //$this->rest_lib->method('GET');

        //file contents....
        $post = file_get_contents('php://input');
        $post = json_decode($post);

        // Validate
        if(!is_object($post) || !isset($post->fname) || !isset($post->lname) || !isset($post->email) || !isset($post->password) || !isset($post->birthdate) || !isset($post->img) || !isset($post->phone) || !isset($post->shirt_size) || !isset($post->shoe_size))
        {
            die('wrong data');
        }
        // Sanitize
        $fname = trim(strip_tags($post->fname));
        $lname = trim(strip_tags($post->lname));
        $email = trim(strip_tags($post->email));
        $password = trim(strip_tags($post->password));
        $birthdate = trim(strip_tags($post->birthdate));
        $img = trim(strip_tags($post->img));
        $phone = trim(strip_tags($post->phone));
        $shirt_size = trim(strip_tags($post->shirt_size));
        $shoe_size = trim(strip_tags($post->shoe_size));

        // Escape
        $safe_fname = (string)$fname;
        $safe_lname = (string)$lname;
        $safe_email = (string)$email;
        $safe_password = (string)$password;
        $safe_birthdate = (string)$birthdate;
        $safe_img = (string)$img;
        $safe_phone = (string)$phone;
        $safe_shirt_size = (string)$shirt_size;
        $safe_shoe_size = (string)$shoe_size;

        $this->load->model('user_model');

        $this->rest_lib->http_response(200, 'OK', $this->user_model->set_user([
            'fname' => $safe_fname,
            'lname' => $safe_lname,
            'email' => $safe_email,
            'password' => $safe_password,
            'birthdate' => $safe_birthdate,
            'img' => $safe_img,
            'phone' => $safe_phone,
            'shirt_size' => $safe_shirt_size,
            'shoe_size' => $safe_shoe_size
        ]));
    }

    public function edit_user($id = null)
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $this->user_lib->authorize();

        //file contents....
        $this->auth_lib->method('PUT');
        $this->load->model('user_model');

        $put = file_get_contents('php://input');
        $put = json_decode($put);

        $this->auth_lib->http_response(200, 'OK', $this->user_model->edit_user($id, [
            'email' => $put->email,
            'password' => $put->password
        ]));
    }

    public function delete_user()
    {
        // check request method with Rest-lib == GET
        $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        $this->user_lib->authorize();

        //file contents....
    }
}
