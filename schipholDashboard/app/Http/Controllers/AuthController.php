<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return "Login form";
    }

    public function login()
    {
        return "Login";
    }

    public function registerForm()
    {
        return "Register form";
    }

    public function register()
    {
        return "Register";
    }

    public function logout()
    {
        return "Logout";
    }
}