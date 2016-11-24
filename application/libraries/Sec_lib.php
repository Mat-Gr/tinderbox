<?php

class Sec_lib
{
    public function secure($args)
    {
        foreach($args as $key => $value)
        {
            if($key == 'password')
            {
                $args->$key = (string)(trim($value));
            }
            else
            {
                $args->$key = (string)(trim(strip_tags($value)));
            }
        }

        return $args;
    }
}
