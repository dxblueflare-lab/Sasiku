<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(): View
    {
        $settings = [
            'site_name' => config('app.name', 'SASIKU'),
            'site_description' => 'Belanja Harian Jadi Elegan',
            'contact_email' => 'info@sasiku.com',
            'contact_phone' => '+62 812 3456 7890',
            'social_facebook' => '#',
            'social_instagram' => '#',
            'social_twitter' => '#',
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(\Illuminate\Http\Request $request): RedirectResponse
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:50',
        ]);

        // TODO: Save settings to database or config file
        // For now, just redirect with success message

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil disimpan');
    }
}
