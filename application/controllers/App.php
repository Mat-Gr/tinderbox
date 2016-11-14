<?php

class App extends CI_Controller
{
    public function schedule() //load schedule
    {
        //load auth lib
        // check request method with Auth-lib == GET
        // check user credentials in database with Auth-lib
        // set display with schedule_model
    }

    public function announcements() //load announcements
    {
        //load auth lib
        // check request method with Auth-lib == GET
        // check user credentials in database with Auth-lib
        // set display with announcements_model
    }

    public function userinfo() //load userinfo (slide in menu)
    {
        //load auth lib
        // check request method with Auth-lib == GET
        // check user credentials in database with Auth-lib
        // set display with user_model
    }

    public function signup()
    {
        //load auth lib
        // check request method with Auth-lib == POST
        //file contents....
    }

    public function edit()
    {
        //load auth lib
        // check request method with Auth-lib == PUT
        // check user credentials in database with Auth-lib
        //file contents....
    }

    public function delete()
    {
        //load auth lib
        // check request method with Auth-lib == DELETE
        // check user credentials in database with Auth-lib
        //file contents....
    }
}
