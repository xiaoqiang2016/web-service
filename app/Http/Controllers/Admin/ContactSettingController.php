<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactSettingController extends Controller
{
    public function index()
    {
        $settings = ContactSetting::with('translation')->orderBy('sort_order')->get();
        return view('admin.contact_settings.index', compact('settings'));
    }

    public function edit(ContactSetting $contactSetting)
    {
        $contactSetting->load('translations');
        $languages = \App\Models\Language::all();
        return view('admin.contact_settings.edit', compact('contactSetting', 'languages'));
    }

    public function update(Request $request, ContactSetting $contactSetting)
    {
        $request->validate([
            'value' => 'required',
            'is_active' => 'boolean',
        ]);

        $contactSetting->update([
            'value' => $request->value,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? $contactSetting->sort_order,
        ]);

        if ($request->has('translations')) {
            foreach ($request->translations as $locale => $translation) {
                $contactSetting->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'label' => $translation['label'],
                        'description' => $translation['description'],
                        'value' => $translation['value'] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('admin.contact-settings.index')->with('success', 'Contact setting updated successfully');
    }
}
