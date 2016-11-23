<?php

class Announcement_model extends CI_Model
{	
	private $pinned = [];
	private $announcements = [];

    public function __construct()
    {
    	$pinned = $this->db->query('SELECT 
    		users.fname, users.lname, announcements.datetime, role.role, announcements.content
    		FROM announcements
    		INNER JOIN users
    		ON announcements.u_id = users.u_id
    		INNER JOIN role
    		ON users.r_id = role.r_id
    		WHERE status = 1 LIMIT 1');

    	$this->pinned = $pinned->row();

    	$announcements = $this->db->query('SELECT 
    		users.fname, users.lname, announcements.datetime, role.role, announcements.content 
    		FROM announcements
    		INNER JOIN users
    		ON announcements.u_id = users.u_id
    		INNER JOIN role
    		ON users.r_id = role.r_id
    		WHERE status = 0
    		ORDER BY announcements.datetime DESC');

    	$this->announcements = $announcements->result();

    /*	$result = $this->db->query('SELECT content, `datetime`
    		FROM announcements WHERE status = 0 ORDER BY `datetime` DESC');*/
    }

    public function get_pinned()
    {
    	return $this->pinned;
    }

    public function get_ann()
    {
    	return $this->announcements;
    }
}
