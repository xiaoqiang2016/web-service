<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutPage;
use App\Models\AboutPageTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutContentController extends Controller
{
    public function index()
    {
        $aboutPage = AboutPage::with('translations')->first();
        $languages = \App\Models\Language::getActive();
        return view('admin.about_contents.index', compact('aboutPage', 'languages'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'translations' => 'required|array',
        ]);

        $aboutPage = AboutPage::first();
        if (!$aboutPage) {
            $aboutPage = AboutPage::create();
        }

        foreach ($request->translations as $locale => $data) {
            $translation = $aboutPage->translations()->where('locale', $locale)->first();
            if ($translation) {
                $translation->update([
                    'content' => $data['content'],
                    'summary' => $data['summary'] ?? null,
                    'team_content' => $data['team_content'] ?? null,
                ]);
            } else {
                AboutPageTranslation::create([
                    'about_page_id' => $aboutPage->id,
                    'locale' => $locale,
                    'content' => $data['content'],
                    'summary' => $data['summary'] ?? null,
                    'team_content' => $data['team_content'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.about-contents.index')->with('success', 'Content updated successfully');
    }
}
