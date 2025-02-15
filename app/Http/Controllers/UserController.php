<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
    @route      GET /login
    @desc       Login form
    @access     Public
    */
    public function login(){
        return view('auth.login');
    }
}
