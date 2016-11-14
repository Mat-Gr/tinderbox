<?php

class User_model extends CI_Model
{
    public function login_user() // for checking user credentials / logging in
    {
        $query = $this->db->query('SELECT email AND password FROM users');
        return $query->result();
    }

    public function get_userinfo() // for getting user-viewable data (name, clothes sizes ext.)
    {

    }

    public function set_user() // create user
    {

    }

    public function edit_user() //.... edit
    {

    }

    public function delete_user() // delete
    {

    }

}
