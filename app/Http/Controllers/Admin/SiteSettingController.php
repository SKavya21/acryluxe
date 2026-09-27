<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    private const FIELDS = [
        'landing.hero.eyebrow',
        'landing.hero.title',
        'landing.hero.copy',
        'landing.visual.kicker',
        'landing.visual.title',
        'landing.visual.copy',
        'landing.catalog.title',
        'landing.catalog.copy',
        'landing.cta.title',
        'landing.cta.copy',
        'landing.footer.copy',
        'landing.footer.note',
        'header.products.label',
        'header.products.url',
        'header.catalog.label',
        'header.catalog.url',
        'header.about.label',
        'header.about.url',
        'footer.collection.label',
        'footer.collection.url',
        'footer.legal.label',
        'footer.legal.url',
        'footer.contact.label',
        'footer.contact.url',
    ];

    public function edit(): View
    {
        $settings = SiteSetting::query()->pluck('value', 'key')->all();

        return view('admin.site-settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];
        foreach (self::FIELDS as $field) {
            $rules[$field] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        foreach (self::FIELDS as $field) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $field],
                ['value' => $validated[$field] ?? null]
            );
        }

        return back()->with('success', 'Landing page settings updated successfully.');
    }
}
