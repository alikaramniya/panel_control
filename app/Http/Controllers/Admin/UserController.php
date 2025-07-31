<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $isAdmin = Gate::forUser(auth()->user())->allows('isAdmin');

        return view('user', compact('isAdmin'));
    }

    public function dashboard()
    {
        try {
            if (auth()->user()->role === 'user') {
                return view('user');
            }

            $users = User::latest()->simplePaginate(10);

            return view('pannel', compact('users'));
        } catch (Exception $e) {
            Log::error('خطایی در گرفتن کاربران پیش آمده' . ' ' . $e->getMessage());
        }
    }

    public function usersList()
    {
        try {
            if (auth()->user()->role === 'user') {
                return response()->json([
                    'type' => 'error',
                    'message' => 'شما دسترسی به لیست ندارید'
                ]);
            }

            $users = User::latest()->limit(10)->get();

            return response()->json([
                'type' => 'success',
                'message' => 'لیست کاربران با موفقیت دریافت شد',
                'users' => $users
            ]);
        } catch (Exception $e) {
            Log::error('خطایی در گرفتن کاربران پیش آمده' . ' ' . $e->getMessage());
        }
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
            $user = User::find($request->id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'کاربری یافت نشد',
                ]);
            }

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:users,id',
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'اطلاعات وارد شده درست نمیباشد',
                ]);
            }

            if (Gate::denies('canUpdatePassword', $user)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'شما دسترسی ندارید به تغییر رمز کاربر',
                ]);
            }

            $user->password = $request->password;

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'رمز با موفقیت به روز رسانی شد'
            ]);
        } catch (Exception $e) {
            Log::error('خطایی در گرفتن کاربر یا به روز رسانی رمز پیش آمده: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'خطایی در به روز رسانی پیش آمده'
            ]);
        }
    }

    public function search(Request $request)
    {
        try {
            $users = User::query()->whereAny(
                ['username', 'name'],
                'like',
                addcslashes($request->search, '%_') . '%'
            )->latest()->limit(20)->get();

            return response()->json([
                'status' => 'success',
                'message' => $users->count() === 0 ? 'کاربری با این مشخصات یافت نشد' : 'اطلاعات با موفقیت دریافت شد',
                'users' => $users,
            ], status: 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'خطایی هنگام جستجو رخ داده است'
            ], 500);
        }
    }

    public function toggle(User $user)
    {
        try {
            if (auth()->user()->role !== 'super_admin') {
                return back();
            }

            if ($user->role === 'super_admin') {
                return back();
            }

            $user->role = $user->role === 'admin' ? 'user' : 'admin';

            $user->save();

            return back();
        } catch (Exception $e) {
            Log::error('خطایی در تغییر وضعیت کاربر پیش آمده ' . $e->getMessage());
        }
    }

    public function delete(User $user)
    {
        try {
            if ($user->role === 'super_admin') {
                return back();
            }

            if (auth()->user()->role === 'admin' && $user->role === 'admin') {
                return back();
            }

            $documents = $user->documents;

            $this->deleteFileAndFolder($documents);

            $user->delete();

            return to_route('dashboard');
        } catch (Exception $e) {
            Log::error('خطایی در حذف کاربر پیش آمده' . ' ' . $e->getMessage());
        }
    }

    public function deleteFileAndFolder($documents)
    {
        try {
            foreach ($documents as $document) {
                $file = $document->file;

                if (Storage::exists($file)) {
                    Storage::delete($file);
                }

                $dirParent = dirname(Storage::path($file));

                if (count(scandir($dirParent)) <= 2) {
                    Storage::deleteDirectory(dirname($file));
                }
            }
        } catch (Exception $e) {
            Log::error('خطایی در حذف پوشه های کاربر به همراه فایل پیش آمده ' . $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        try {
            $user = User::find($request->id);

            if (!$user) { // User not successfully retrieved
                return response()->json([
                    'type' => 'error',
                    'message' => 'در گرفتن کاربر خطایی رخ داده'
                ]);
            }

            $oldProfilePath = $user->profile;

            if ($request->action === 'upload') {
                $validator = Validator::make($request->all(), [
                    'avatar' => 'required|file|mimes:png,jpg,pdf|max:1024'
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'حجم بالاس یا فرمت اشتبا'
                    ]);
                }

                $path = $request->avatar->store('avatar');
                $message = 'آپلود شد :)';
            } else {
                $path = 'avatar_def/user-icon.png';
                $message = 'حذف شد :(';
            }

            $user->profile = $path;

            $user->save();

            // Check image proifle uploaded successfully or no
            if ($user->save()) {
                if (
                    $oldProfilePath !== 'avatar_def/user-icon.png' &&
                    Storage::exists($oldProfilePath)
                ) { // Delete old image if update successfully
                    Storage::delete($oldProfilePath);
                }
            } else if ( // Delete new image if user not updated
                $path !== 'avatar_def/user-icon.png' &&
                Storage::exists($path)
            ) {
                Storage::delete($path);
            }

            return response()->json([
                'status' => 'success',
                'path' => $path,
                'message' => $message
            ]);
        } catch (Exception $e) {
            Log::error('خطایی هنگام آپلود تصویر پیش آمده : ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'آپلود نشد :('
            ]);
        }
    }

    public function getImage(Request $request)
    {
        try {
            return response()->json([
                'status' => 'success',
                'path' => User::find($request->id)->profile,
            ]);
        } catch (Exception $e) {
            Log::error('خطایی در گرفتن تصویر کاربر پیش آمده : ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'خطایی در گرفتن تصیویر پیش آمده'
            ]);
        }
    }
}
