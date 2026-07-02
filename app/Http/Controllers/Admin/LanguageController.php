<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('sort_order')->get();
        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'locale' => 'required|unique:languages',
            'name' => 'required',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->is_default) {
            Language::where('is_default', 1)->update(['is_default' => 0]);
        }

        Language::create($request->all());

        return redirect()->route('admin.languages.index')->with('success', 'Language created');
    }

    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'locale' => 'required|unique:languages,locale,' . $language->id,
            'name' => 'required',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        if ($request->is_default && $language->is_default != 1) {
            Language::where('is_default', 1)->update(['is_default' => 0]);
        }

        $language->update($request->all());

        return redirect()->route('admin.languages.index')->with('success', 'Language updated');
    }

    public function destroy(Language $language)
    {
        if ($language->is_default) {
            return back()->withErrors(['error' => 'Cannot delete default language']);
        }
        $language->delete();
        return redirect()->route('admin.languages.index')->with('success', 'Language deleted');
    }
}
