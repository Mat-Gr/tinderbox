<?php

class User_model extends CI_Model
{
    public function login_user($email, $password) // for checking user credentials / logging in
    {
        // implement security here
        // Validate

        if(!isset($email) || !isset($password))
        {
            die('wrong data');
        }

        // Sanitize
        $email = trim(strip_tags($email));
        $password = trim(strip_tags($password));

        // Escape
        $safe_password = (string)$password;

        $res = $this->db->query(sprintf('SELECT
            email, password
            FROM users
            WHERE
            email = "%s"
            LIMIT 1'
            , $this->db->escape_like_str($email)));

        if(password_verify($safe_password, $res->row('password')))
        {
            return true;
        }
        return false;
    }

    public function get_userinfo($email, $password) // for getting user-viewable data (name, clothes sizes ext.)
    {
        // implement security here
        // Validate

        if(!isset($email) || !isset($password))
        {
            die('wrong data');
        }

        // Sanitize
        $email = trim(strip_tags($email));
        $password = trim(strip_tags($password));

        // Escape
        $safe_password = (string)$password;

        $res = $this->db->query(sprintf('SELECT
            *
            FROM users
            WHERE
            email = "%s"
            LIMIT 1'
            , $this->db->escape_like_str($email)));

        if(password_verify($safe_password, $res->row('password')))
        {
            return $res->result();
        }
        return false;

    }

    public function set_user($args = []) // create user
    {
        $fname = $args['fname'];
        $lname = $args['lname'];
        $email = $args['email'];
        $password = $args['password'];
        $birthdate = $args['birthdate'];
        $img = $args['img'];
        $phone = $args['phone'];
        $shirt_size = $args['shirt_size'];
        $shoe_size = $args['shoe_size'];

        $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        $query = sprintf('INSERT into users
            (fname, lname, email, password, birthdate, img, phone, shirt_size, shoe_size)
            VALUES
            ("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s")'
            , $fname
            , $lname
            , $email
            , $hash_password
            , $birthdate
            , $img
            , $phone
            , $shirt_size
            , $shoe_size);

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
        SET password = "%s", img = "%s", phone = "%s", shirt_size = "%s", shoe_size = "%s"
        WHERE u_id = "%s"'
        , $args['password']
        , $args['img']
        , $args['phone']
        , $args['shirt_size']
        , $args['shoe_size']
        , $id);

        $this->db->query($query);

        return $id;
    }

    public function delete_user() // delete
    {

    }

}
