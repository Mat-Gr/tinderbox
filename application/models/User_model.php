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
            u_id, email, password
            FROM users
            WHERE
            email = "%s"
            LIMIT 1'
            , $this->db->escape_like_str($email)));

        if(!password_verify($safe_password, $res->row('password')))
        {
            return false; // http_response
        }

        $query = sprintf('SELECT
            token
            FROM user_tokens
            WHERE
            u_id = %d',
            $this->db->escape_like_str($res->row('u_id')));


        $res = $this->db->query($query);

        if(!($res === false) && is_string($res->row('token')))
        {
            return $res->row('token');
        }
        return false;

    }

    public function get_userinfo($token) // for getting user-viewable data (name, clothes sizes ext.)
    {
        // implement security here
        $query = sprintf('SELECT
            users.fname, users.lname, team.team, role.role, users.birthdate, users.phone, users.shirt_size, users.shoe_size
            FROM users
            INNER JOIN user_tokens
            ON users.u_id=user_tokens.u_id
            INNER JOIN team
            ON users.t_id=team.t_id
            INNER JOIN role
            ON users.r_id=role.r_id
            WHERE
            token = "%s"',
            $this->db->escape_like_str($token));

        $res = $this->db->query($query);

        if(!empty($res))
        {
            return $res->row();
        }
        else return false;
    }

    public function set_user($args = []) // create user
    {
        $fname = $args['fname'];
        $lname = $args['lname'];
        $email = $args['email'];
        $password = $args['password'];
        $birthdate = $args['birthdate'];
        $phone = $args['phone'];
        $shirt_size = $args['shirt_size'];
        $shoe_size = $args['shoe_size'];

        $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        // Validate
        if(!isset($fname) || !isset($lname) || !isset($email) || !isset($hash_password) || !isset($birthdate) || !isset($phone) || !isset($shirt_size) || !isset($shoe_size))
        {
            die('Bad ID');
        }

        // Sanitize
        $san_fname = trim(strip_tags($fname));
        $san_lname = trim(strip_tags($lname));
        $san_email = trim(strip_tags($email));
        $san_password = trim(strip_tags($hash_password));
        $san_birthdate = trim(strip_tags($birthdate));
        $san_phone = trim(strip_tags($phone));
        $san_shirt_size = trim(strip_tags($shirt_size));
        $san_shoe_size = trim(strip_tags($shoe_size));

        // Escape
        $none_tainted_fname = $this->db->escape_str((string)$san_fname);
        $none_tainted_lname = $this->db->escape_str((string)$san_lname);
        $none_tainted_email = $this->db->escape_str((string)$san_email);
        $none_tainted_password = $this->db->escape_str((string)$san_password);
        $none_tainted_birthdate = $this->db->escape_str((string)$san_birthdate);
        $none_tainted_phone = $this->db->escape_str((string)$san_phone);
        $none_tainted_shirt_size = $this->db->escape_str((string)$san_shirt_size);
        $none_tainted_shoe_size = $this->db->escape_str((string)$san_shoe_size);

        $query = sprintf('INSERT into users
            (fname, lname, email, password, birthdate, phone, shirt_size, shoe_size)
            VALUES
            ("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s")'
            , $none_tainted_fname
            , $none_tainted_lname
            , $none_tainted_email
            , $none_tainted_password
            , $none_tainted_birthdate
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

    public function edit_user($token, $args = []) //.... edit
    {
        $password = $args['password'];
        $phone = $args['phone'];
        $shirt_size = $args['shirt_size'];
        $shoe_size = $args['shoe_size'];

        $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

        // Validate
        if(!isset($hash_password) || !isset($phone) || !isset($shirt_size) || !isset($shoe_size))
        {
            die('Bad ID');
        }

        // Sanitize
        $san_token = trim(strip_tags($token));
        $san_password = trim(strip_tags($hash_password));
        $san_phone = trim(strip_tags($phone));
        $san_shirt_size = trim(strip_tags($shirt_size));
        $san_shoe_size = trim(strip_tags($shoe_size));

        // Escape
        $none_tainted_token = $this->db->escape_str((string)$san_token);
        $none_tainted_password = $this->db->escape_str((string)$san_password);
        $none_tainted_phone = $this->db->escape_str((string)$san_phone);
        $none_tainted_shirt_size = $this->db->escape_str((string)$san_shirt_size);
        $none_tainted_shoe_size = $this->db->escape_str((string)$san_shoe_size);

        $query = sprintf('UPDATE users
            INNER JOIN user_tokens
            ON users.u_id=user_tokens.u_id
            SET users.password = "%s", users.phone = "%s", users.shirt_size = "%s", users.shoe_size = "%s"
            WHERE token = "%s"'
            , $none_tainted_password
            , $none_tainted_phone
            , $none_tainted_shirt_size
            , $none_tainted_shoe_size
            , $none_tainted_token);

        if($this->db->query($query))
        {
            return true;
        }

        return false;


    }

    public function delete_user($token) // delete
    {
        $query = sprintf('DELETE users, user_tokens FROM
            users
            INNER JOIN user_tokens
            ON users.u_id = user_tokens.u_id
            WHERE token = "%s"',
            $token);

        if($this->db->query($query))
        {
            return true;
        }

        return false;
    }

}
