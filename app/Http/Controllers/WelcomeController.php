<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function home()
    {
        $users = User::count();
        return view('home', ['users'=> $users]);
    }
}
