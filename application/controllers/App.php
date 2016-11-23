<?php

class App extends CI_Controller
{
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
        unset($userinfo->t_id);
        unset($userinfo->r_id);

        $this->rest_lib->http_response(200, 'OK', $userinfo);
    }

    public function signup()
    {
        $this->rest_lib->method('POST');

        //file contents....
        $post = file_get_contents('php://input');
        $post = json_decode($post);

        // Validate -- NEEDS CHECKING IF EMPTY!!!!!!!!!!!!!!!!
        if(!is_object($post) || !isset($post->fname) || !isset($post->lname) || !isset($post->email) || !isset($post->password) || !isset($post->birthdate) || !isset($post->phone) || !isset($post->shirt_size) || !isset($post->shoe_size))
        {
            $this->rest_lib->http_response(400, 'Bad Request', 'Wrong data');
        }
        // Sanitize
        $fname = trim(strip_tags($post->fname));
        $lname = trim(strip_tags($post->lname));
        $email = trim(strip_tags($post->email));
        $password = trim(strip_tags($post->password));
        $birthdate = trim(strip_tags($post->birthdate));
        $phone = trim(strip_tags($post->phone));
        $shirt_size = trim(strip_tags($post->shirt_size));
        $shoe_size = trim(strip_tags($post->shoe_size));

        // Escape
        $safe_fname = (string)$fname;
        $safe_lname = (string)$lname;
        $safe_email = (string)$email;
        $safe_password = (string)$password;
        $safe_birthdate = (string)$birthdate;
        $safe_phone = (string)$phone;
        $safe_shirt_size = (string)$shirt_size;
        $safe_shoe_size = (string)$shoe_size;

        $this->load->model('user_model');

        $res = $this->user_model->set_user([
            'fname' => $safe_fname,
            'lname' => $safe_lname,
            'email' => $safe_email,
            'password' => $safe_password,
            'birthdate' => $safe_birthdate,
            'phone' => $safe_phone,
            'shirt_size' => $safe_shirt_size,
            'shoe_size' => $safe_shoe_size
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
        if(!isset($put->password) || !isset($put->phone) || !isset($put->shirt_size) || !isset($put->shoe_size)) // The edit fails if none of the fields are filled out, since it won't know what to edit - maybe we need to use empty as well as isset?
        {
            die('No fields have been changed'); // Not sure the validate works, since it edits no matter what - find out why
        }

        // Sanitize
        $san_token = trim(strip_tags($token));
        $san_password = trim(strip_tags($put->password));
        $san_phone = trim(strip_tags($put->phone));
        $san_shirt_size = trim(strip_tags($put->shirt_size));
        $san_shoe_size = trim(strip_tags($put->shoe_size));

        // Escape
        $none_tainted_token = $this->db->escape_str((string)$san_token);
        $none_tainted_password = $this->db->escape_str((string)$san_password);
        $none_tainted_phone = $this->db->escape_str((string)$san_phone);
        $none_tainted_shirt_size = $this->db->escape_str((string)$san_shirt_size);
        $none_tainted_shoe_size = $this->db->escape_str((string)$san_shoe_size);

        $this->load->model('user_model');

        $this->rest_lib->http_response(200, 'OK', $this->user_model->edit_user($none_tainted_token, [
            'password' => $none_tainted_password,
            'phone' => $none_tainted_phone,
            'shirt_size' => $none_tainted_shirt_size,
            'shoe_size' => $none_tainted_shoe_size
        ]));
    }

    public function delete_user()
    {
        $this->rest_lib->method('DELETE');

        // check user credentials in database with User-lib
        $this->user_lib->authorize();

        //file contents....
    }
}
