<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
{
    public function showAllMembers()
    {
        $users = User::whereKeyNot(Auth::user()->id)->paginate(5);
        return view('members.index', ['users'=> $users]);
    }
}
