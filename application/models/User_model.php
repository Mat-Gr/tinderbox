<?php

class User_model extends CI_Model
{
    public function login_user($email, $password) // for checking user credentials / logging in
    {
        // implement security here
        $res = $this->db->query(sprintf('SELECT
            email, password
            FROM users
            WHERE
            email = "%s"
            LIMIT 1'
            , $this->db->escape_like_str($email)));

        if(password_verify($password, $res->row('password')))
        {
            return true;
        }
        return false;
    }

    public function get_userinfo($email, $password) // for getting user-viewable data (name, clothes sizes ext.)
    {
        // implement security here
        $res = $this->db->query(sprintf('SELECT
            *
            FROM users
            WHERE
            email = "%s"
            LIMIT 1'
            , $this->db->escape_like_str($email)));

        if(password_verify($password, $res->row('password')))
        {
            return $res->result();
        }
        return false;

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
        WHERE u_id = "%s"'
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
