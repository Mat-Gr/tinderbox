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
    }

    public function edit()
    {
        //load auth lib
        // check request method with Auth-lib == PUT
        // check user credentials in database with Auth-lib
        //file contents....
    }

    public function delete()
    {
        //load auth lib
        // check request method with Auth-lib == DELETE
        // check user credentials in database with Auth-lib
        //file contents....
    }
}
