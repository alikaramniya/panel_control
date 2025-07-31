<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        try {
            $user = User::find($request->user_id, 'username');

            $path = $request->file->store("document/" . $user->username);

            $extension = $request->file->getClientOriginalExtension();

            $fileType = 'pdf';
            if ($extension !== 'pdf') {
                $fileType = 'file';
            }

            Document::create([
                'user_id' => (int)$request->user_id,
                'file_type' => $fileType,
                'file' => $path,
                'file_name' => $request->file_name,
                'file_date_upload' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'عملیات ذخیره سازی با موفقیت انجام شد'
            ]);
        } catch (Exception $e) {
            Log::error('Add new document error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'در اضافه کردن سند جدید مشگلی پیش آمده'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        try {
            $file = $document->file;

            if (Storage::exists($file)) {
                Storage::delete($file);
            }

            $dirParent = dirname(Storage::path($file));

            if (count(scandir($dirParent)) <= 2) {
                Storage::deleteDirectory(dirname($file));
            }

            $document->delete();

            return back();
        } catch (Exception $e) {
            Log::error('خطایی در حذف یک سند پیش آمده ' . $e->getMessage());
        }
    }

    public function listDocument(Request $request)
    {
        try {
            $user = User::with('documents')->find($request->input('id'));

            $isAdmin = Gate::forUser($user)->allows('isAdmin');

            return view('user', compact('user', 'isAdmin'));
        } catch (Exception $e) {
            Log::error('خطایی در گرفتن لیست اسناد یک کاربر پیش آمده ' . $e->getMessage());
        }
    }

    public function download(Document $document)
    {
        try {
            $file = Str::replaceFirst('public', 'storage/public', $document->file);

            if (Storage::exists($file)) {
                return Storage::download($file);
            }
        } catch (Exception $e) {
            Log::error('خطایی در دانلود فایل پیش آمده' . ' ' . $e->getMessage());
        }
    }

    public function show(Document $document)
    {
        try {
            $file = Str::replaceFirst('public', 'storage/public', $document->file);

            if (Storage::exists($file)) {
                if ($document->file_type === 'file') {
                    return "<img src='/storage/$file' />" ;
                }

                return '/storage/' . $file;
            }
        } catch (Exception $e) {
            Log::error('خطایی در نمایش فایل پیش آمده برای پرینت گرفتن ' . $e->getMessage());
        }
    }
}
