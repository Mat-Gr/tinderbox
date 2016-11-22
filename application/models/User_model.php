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

        // Validate
        if(!isset($fname) || !isset($lname) || !isset($email) || !isset($hash_password) || !isset($birthdate) || !isset($img) || !isset($phone) || !isset($shirt_size) || !isset($shoe_size))
        {
            die('Bad ID');
        }

        // Sanitize
        $san_fname = trim(strip_tags($fname));
        $san_lname = trim(strip_tags($lname));
        $san_email = trim(strip_tags($email));
        $san_password = trim(strip_tags($hash_password));
        $san_birthdate = trim(strip_tags($birthdate));
        $san_img = trim(strip_tags($img));
        $san_phone = trim(strip_tags($phone));
        $san_shirt_size = trim(strip_tags($shirt_size));
        $san_shoe_size = trim(strip_tags($shoe_size));

        // Escape
        $none_tainted_fname = $this->db->escape_str((string)$san_fname);
        $none_tainted_lname = $this->db->escape_str((string)$san_lname);
        $none_tainted_email = $this->db->escape_str((string)$san_email);
        $none_tainted_password = $this->db->escape_str((string)$san_password);
        $none_tainted_birthdate = $this->db->escape_str((string)$san_birthdate);
        $none_tainted_img = $this->db->escape_str((string)$san_img);
        $none_tainted_phone = $this->db->escape_str((string)$san_phone);
        $none_tainted_shirt_size = $this->db->escape_str((string)$san_shirt_size);
        $none_tainted_shoe_size = $this->db->escape_str((string)$san_shoe_size);

        $query = sprintf('INSERT into users
            (fname, lname, email, password, birthdate, img, phone, shirt_size, shoe_size)
            VALUES
            ("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s")'
            , $none_tainted_fname
            , $none_tainted_lname
            , $none_tainted_email
            , $none_tainted_password
            , $none_tainted_birthdate
            , $none_tainted_img
            , $none_tainted_phone
            , $none_tainted_shirt_size
            , $none_tainted_shoe_size);

        $this->db->query($query);

        $id = (int)$this->db->insert_id();

        // add user token
        //generate user token
        $user_token = bin2hex(openssl_random_pseudo_bytes(16));

        $query = sprintf('INSERT into user_tokens
            (u_id, token)
            VALUES
            (%d, "%s")'
            , $this->db->escape_like_str($id)
            , $this->db->escape_like_str($user_token));

        $this->db->query($query);
        $res = $this->db->affected_rows();

        if($res === 1)
        {
            return $user_token;
        }

        return false;
    }

    public function edit_user($id, $args = []) //.... edit
    {
        $password = $args['password'];
        $img = $args['img'];
        $phone = $args['phone'];
        $shirt_size = $args['shirt_size'];
        $shoe_size = $args['shoe_size'];

        $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        // Validate

        if($id === null)
        {
            die('Bad ID');
        }

        if(!preg_match('/^[0-9]+$/', $id))
        {
            die('Bad ID'); // Can you use libraries in models?
        }

        if(!isset($hash_password) || !isset($img) || !isset($phone) || !isset($shirt_size) || !isset($shoe_size))
        {
            die('Bad ID');
        }

        // Sanitize
        $san_id = trim(strip_tags($id));
        $san_password = trim(strip_tags($hash_password));
        $san_img = trim(strip_tags($img));
        $san_phone = trim(strip_tags($phone));
        $san_shirt_size = trim(strip_tags($shirt_size));
        $san_shoe_size = trim(strip_tags($shoe_size));

        // Escape
        $none_tainted_id = $this->db->escape_str((int)$san_id);
        $none_tainted_password = $this->db->escape_str((string)$san_password);
        $none_tainted_img = $this->db->escape_str((string)$san_img);
        $none_tainted_phone = $this->db->escape_str((string)$san_phone);
        $none_tainted_shirt_size = $this->db->escape_str((string)$san_shirt_size);
        $none_tainted_shoe_size = $this->db->escape_str((string)$san_shoe_size);

        $query = sprintf('UPDATE users
        SET password = "%s", img = "%s", phone = "%s", shirt_size = "%s", shoe_size = "%s"
        WHERE u_id = "%s"'
        , $none_tainted_password
        , $none_tainted_img
        , $none_tainted_phone
        , $none_tainted_shirt_size
        , $none_tainted_shoe_size
        , $none_tainted_id);

        $this->db->query($query);

        return $id; // What should be output to the user? Status message, updated info etc.?
    }

    public function delete_user() // delete
    {

    }

}
