<?php

class App extends CI_Controller
{
    public function schedule() //load schedule
    {
        // check request method with Auth-lib == GET
        // $this->auth_lib->method('GET');
        // check user credentials in database with Auth-lib
        // $user_res = $this->auth_lib->authorize();
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
        //load auth lib
        // check request method with Auth-lib == GET
        // check user credentials in database with Auth-lib
        // set output with announcements_model
    }

    public function userinfo() //load userinfo (slide in menu)
    {
      //load auth lib
      // check request method with Auth-lib == GET
      // check user credentials in database with Auth-lib
      // set output with user_model
      $this->load->model('user_model');

      $model_res = $this->user_model->get_userinfo();

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

    public function signup()
    {
        //load auth lib
        // check request method with Auth-lib == POST
        //file contents....

        $post = file_get_contents('php://input');
        $post = json_decode($post);

        // Validate
        if(!is_object($post) || !isset($post->email) || !isset($post->password))
        {
            die('wrong data');
        }

        // Sanitize
        $email = trim(strip_tags($post->email));
        $password = trim(strip_tags($post->password));

        // Escape
        $safe_email = (string)$email;
        $safe_password = (string)$password;

        $this->load->model('user_model');

        $this->auth_lib->http_response(200, 'OK', $this->user_model->set_user([
            'email' => $safe_email,
            'password' => $safe_password
        ]));
    }

    public function edit($id = null)
    {
        //load auth lib
        // check request method with Auth-lib == PUT
        // check user credentials in database with Auth-lib
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

    public function delete()
    {
        //load auth lib
        // check request method with Auth-lib == DELETE
        // check user credentials in database with Auth-lib
        //file contents....
    }
}
