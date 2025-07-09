<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        try {
            $path = $request->file->store('document');

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

            return response()->json(['success' => 'عملیات ذخیره سازی با موفقیت انجام شد']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }

    public function listDocument(Request $request)
    {
        $user = User::with('documents')->find($request->input('id'));

        return view('user', compact('user'));
    }

    public function download(Document $document)
    {
        $file = Str::replaceFirst('public', 'storage/public', $document->file);

        if (Storage::exists($file)) {
            return Storage::download($file);
        }
    }

    public function show(Document $document)
    {
        $file = Str::replaceFirst('public', 'storage/public', $document->file);

        if (Storage::exists($file)) {
            if ($document->file_type === 'file') {
                return "<img src='/storage/$file' />" ;
            }

            return '/storage/' . $file;
        }
    }
}
