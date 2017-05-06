<?php

class Schedule_model extends CI_Model
{
    public function get_schedule($token = "")
    {
        if(empty($token) || !is_string($token))
        {
            return false;
        }

        $token = (string)trim(strip_tags($token));

        $query = sprintf('SELECT
            schedule_item.start, schedule_item.end, schedule_item.task, team.team, schedule_item.location
            FROM schedule_item
            INNER JOIN schedule
            ON schedule_item.si_id = schedule.si_id
            INNER JOIN users
            ON schedule.u_id = users.u_id
            INNER JOIN user_tokens
            ON users.u_id = user_tokens.u_id
            INNER JOIN team
            ON schedule_item.t_id = team.t_id
            WHERE token = "%s"
            AND schedule_item.end > NOW()
            ORDER BY schedule_item.start ASC
            LIMIT 10',
            $this->db->escape_like_str($token));

        $res = $this->db->query($query);

        if(!empty($res->result()))
        {
            return $res->result();
        }
        return false;
    }
}
