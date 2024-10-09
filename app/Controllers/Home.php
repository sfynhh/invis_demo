<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        // print_r(session()->get());
        return view('welcome_message');
    }
}
