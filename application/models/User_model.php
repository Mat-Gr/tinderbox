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

    public function set_user($args = []) // create user
    {
        $query = sprintf('INSERT into users
            (email, password)
            VALUES
            ("%s", "%s")'
            , $args['email']
            , $args['password']);

        $this->db->query($query);

        $id = $this->db->insert_id();

        if(is_int($id) && $id > 0)
        {
            return $id;
        }

        return false;
    }

    public function edit_user($id, $args = []) //.... edit
    {
        $query = sprintf('UPDATE users
        SET email = "%s", password = "%s"
        WHERE id = "%s"'
        , $args['email']
        , $args['password']
        , $id);

        $this->db->query($query);

        return $id;
    }

    public function delete_user() // delete
    {

    }

}
