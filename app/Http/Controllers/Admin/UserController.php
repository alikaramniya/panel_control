<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function store(UserStoreRequest $request)
    {
        try {
            User::create($request->validated());

            return back()->withSuccess('اکانت با موفقیت ساخته شد');
        } catch (Exception $e) {
            Log::error('Error when create new user account ' . $e->getMessage());
        }
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


    public function updatePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'password' => 'required|min:8',
            ], [
                'password.required' => 'رمز نمیتونه خالی باشه.',
                'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ]);
            }

            $user = User::find($request->id);

            $user->password = $request->password;

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'رمز با موفقیت به روز رسانی شد'
            ]);
        } catch (Exception $e) {
            Log::error('خطایی رخ داده در گرفتن کاربر');
        }
    }

}
