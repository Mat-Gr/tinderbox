<?php

class User_model extends CI_Model
{
    public function get_user()
    {
        $query = $this->db->query('SELECT email AND password FROM users');
        return $query->result();
    }

    public function set_user()
    {

    }

    public function edit_user()
    {

    }

    public function delete_user()
    {

    }

}
