<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:2048',
        ]);

        $file = $request->file('upload');
        $path = $file->store('uploads', 'public');
        $url = asset('storage/' . $path);

        return response()->json([
            'uploaded' => true,
            'url' => $url,
        ]);
    }
}
