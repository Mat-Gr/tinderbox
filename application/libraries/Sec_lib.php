<?php

class Sec_lib
{
    public function validate($args, $req) // takes arguments to validate, and requirements for teh validation
    {
        foreach($req as $value)
        {
            if(!property_exists($args, $value)) // check if the required properties exist
            {
                return false;
            }
        }
        foreach($args as $key => $value)
        {
            if(!in_array($key, $req)) // check if unwanted properties exist
            {
                return false;
            }
            elseif(!isset($value) || empty($value) || !is_string($value)) // validate each value
            {
                return false;
            }
        }
        return true;
    }

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
