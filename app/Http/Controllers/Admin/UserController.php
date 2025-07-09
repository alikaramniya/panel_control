<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('user');
    }
    
    public function dashboard()
    {
        if (auth()->user()->role === 'user') {
            return view('user');
        }

        $users = User::latest()->take(5)->get();

        return view('pannel', compact('users'));
    }
}
