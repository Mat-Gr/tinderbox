<?php

class Announcement_model extends CI_Model
{
    public function __construct()
    {

    }

    public function get_ann($id)
    {
    	$pinned = $this->db->query('SELECT id, content, `datetime`, status FROM announcements WHERE status = 1 LIMIT 1')

    	$result = $this->db->query('SELECT id, content, `datetime`, status
    		FROM announcements WHERE status = 0 ORDER BY `datetime` DESC LIMIT 3')
    }
}
