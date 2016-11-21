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
            die('Please fill out all fields');
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
        // $this->rest_lib->method('GET');

        // check user credentials in database with User-lib
        // $this->user_lib->authorize();

        //file contents....
        $put = file_get_contents('php://input');
        $put = json_decode($put);

        // Validate
        if($id === null)
        {
            $this->rest_lib->http_response(400, 'Bad request', 'Bad ID');
        }

        if(!preg_match('/^[0-9]+$/', $id))
        {
            $this->rest_lib->http_response(400, 'Bad request', 'Bad ID');
        }

        if(!isset($put->password) || !isset($put->img) || !isset($put->phone) || !isset($put->shirt_size) || !isset($put->shoe_size)) // The edit fails if none of the fields are filled out, since it won't know what to edit
        {
            die('No fields have been changed'); // Not sure the validate works, since it edits no matter what - find out why
        }

        // Sanitize
        $san_id = trim(strip_tags($id));
        $san_password = trim(strip_tags($put->password));
        $san_img = trim(strip_tags($put->img));
        $san_phone = trim(strip_tags($put->phone));
        $san_shirt_size = trim(strip_tags($put->shirt_size));
        $san_shoe_size = trim(strip_tags($put->shoe_size));

        // Escape
        $none_tainted_id = $this->db->escape_str((int)$san_id); // IS it valid to make it int inside the escape function?
        $none_tainted_password = $this->db->escape_str((string)$san_password); // Same question as above?
        $none_tainted_img = $this->db->escape_str((string)$san_img);
        $none_tainted_phone = $this->db->escape_str((string)$san_phone);
        $none_tainted_shirt_size = $this->db->escape_str((string)$san_shirt_size);
        $none_tainted_shoe_size = $this->db->escape_str((string)$san_shoe_size);

        $this->load->model('user_model');

        $this->rest_lib->http_response(200, 'OK', $this->user_model->edit_user($none_tainted_id, [
            'password' => $none_tainted_password,
            'img' => $none_tainted_img,
            'phone' => $none_tainted_phone,
            'shirt_size' => $none_tainted_shirt_size,
            'shoe_size' => $none_tainted_shoe_size
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
