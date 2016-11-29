<?php

class User_model extends CI_Model
{
    public function login_user($email, $password) // for checking user credentials / logging in
    {
        if(!isset($email) || empty($email) || !is_string($email)
            || !isset($password) || empty($password) || !is_string($password))
        {
            return false;
        }

        // Sanitize
        $email = trim(strip_tags($email));
        $password = trim(strip_tags($password));

        // Escape
        $safe_email = (string)$email;
        $safe_password = (string)$password;

        $res = $this->db->query(sprintf('SELECT
            u_id, email, password
            FROM users
            WHERE
            email = "%s"
            LIMIT 1'
            , $this->db->escape_like_str($safe_email)));

        if(!password_verify($safe_password, $res->row('password')))
        {
            return false;
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
        if(empty($token) || !is_string($token))
        {
            return false;
        }
        $token = (string)trim(strip_tags($token));

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
        // Validate
        $req = [
            'fname',
            'lname',
            'email',
            'password',
            'birthdate',
            'phone',
            'shirt_size',
            'shoe_size'
        ];

        if(!is_object($args) || $this->sec_lib->validate($args, $req) === false)
        {
            return false;
        }

        // Sanitize & escape
        $secured = $this->sec_lib->secure($args);

        $hash_password = password_hash($secured->password, PASSWORD_BCRYPT, ['cost' => 10]);

        $query = sprintf('INSERT into users
            (fname, lname, email, password, birthdate, phone, shirt_size, shoe_size)
            VALUES
            ("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s")'
            ,  $this->db->escape_like_str($secured->fname)
            ,  $this->db->escape_like_str($secured->lname)
            ,  $this->db->escape_like_str($secured->email)
            ,  $this->db->escape_like_str($hash_password)
            ,  $this->db->escape_like_str($secured->birthdate)
            ,  $this->db->escape_like_str($secured->phone)
            ,  $this->db->escape_like_str($secured->shirt_size)
            ,  $this->db->escape_like_str($secured->shoe_size));

        $this->db->query($query);

        $id = (int)$this->db->insert_id();

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
        if(empty($token) || !is_string($token))
        {
            return false;
        }
        $token = (string)trim(strip_tags($token));

        // Validate
        $req = [
            'password',
            'phone',
            'shirt_size',
            'shoe_size'
        ];

        if(!is_object($args) || $this->sec_lib->validate($args, $req) === false)
        {
            $this->rest_lib->http_response(400, 'Bad Request', 'Wrong data');
        }

        // Sanitize
        $secured = $this->sec_lib->secure($args);

        $hash_password = password_hash($secured->password, PASSWORD_BCRYPT, ['cost' => 10]);

        $query = sprintf('UPDATE users
            INNER JOIN user_tokens
            ON users.u_id=user_tokens.u_id
            SET users.password = "%s", users.phone = "%s", users.shirt_size = "%s", users.shoe_size = "%s"
            WHERE token = "%s"'
            , $this->db->escape_like_str($hash_password)
            , $this->db->escape_like_str($secured->phone)
            , $this->db->escape_like_str($secured->shirt_size)
            , $this->db->escape_like_str($secured->shoe_size)
            , $this->db->escape_like_str($token));

        if($this->db->query($query))
        {
            return true;
        }
        return false;
    }

    public function delete_user($token) // delete
    {
        if(empty($token) || !is_string($token))
        {
            return false;
        }
        $token = (string)trim(strip_tags($token));

        $query = sprintf('DELETE users, user_tokens FROM
            users
            INNER JOIN user_tokens
            ON users.u_id = user_tokens.u_id
            WHERE token = "%s"',
            $this->db->escape_like_str($token));

        if($this->db->query($query))
        {
            return true;
        }
        return false;
    }
}
