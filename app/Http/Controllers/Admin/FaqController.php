<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\FaqTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('translation')->orderBy('sort_order')->paginate(10);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.faqs.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sort_order' => 'integer',
            'is_show' => 'boolean',
        ]);

        $faq = Faq::create([
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
        ]);

        foreach ($request->translations as $locale => $data) {
            FaqTranslation::create([
                'faq_id' => $faq->id,
                'locale' => $locale,
                'question' => $data['question'],
                'answer' => $data['answer'],
            ]);
        }

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created');
    }

    public function edit(Faq $faq)
    {
        $languages = Language::getActive();
        return view('admin.faqs.edit', compact('faq', 'languages'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'sort_order' => 'integer',
            'is_show' => 'boolean',
        ]);

        $faq->update([
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
        ]);

        foreach ($request->translations as $locale => $data) {
            $translation = $faq->translations()->where('locale', $locale)->first();
            if ($translation) {
                $translation->update([
                    'question' => $data['question'],
                    'answer' => $data['answer'],
                ]);
            } else {
                FaqTranslation::create([
                    'faq_id' => $faq->id,
                    'locale' => $locale,
                    'question' => $data['question'],
                    'answer' => $data['answer'],
                ]);
            }
        }

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted');
    }
}
