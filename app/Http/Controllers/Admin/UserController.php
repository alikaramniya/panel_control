<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function create()
    {
        return view('create_user');
    }

    public function user(Request $request)
    {
        try {
            $user = User::find($request->id);

            return response()->json([
                'user' => $user
            ]);
        } catch (Exception $e) {
            Log::error('خطایی رخ داده در گرفتن کاربر');
        }
    }

}
