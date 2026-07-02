<?php

namespace App\Http\Controllers\Admin;

use App\Models\HonorImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HonorImageController extends Controller
{
    public function index()
    {
        $images = HonorImage::orderBy('sort_order')->paginate(12);
        return view('admin.honor_images.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('honor_images', 'public');

        HonorImage::create([
            'image' => $imagePath,
            'caption' => $request->caption,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? true,
        ]);

        return redirect()->route('admin.honor-images.index')->with('success', 'Image added successfully');
    }

    public function update(Request $request, HonorImage $honorImage)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
        ]);

        $honorImage->update([
            'caption' => $request->caption,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? true,
        ]);

        return redirect()->route('admin.honor-images.index')->with('success', 'Image updated successfully');
    }

    public function destroy(HonorImage $honorImage)
    {
        $honorImage->delete();
        return redirect()->route('admin.honor-images.index')->with('success', 'Image deleted successfully');
    }
}
