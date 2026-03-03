<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $settings = [
            'library_name'        => config('app.name', 'Sistema Bibliotecario Universitario'),
            'contact_email'       => 'biblioteca@universita.edu',
            'timezone'            => 'Europe/Rome',
            'default_status'      => 'pending',
            'records_per_page'    => 20,
            'enable_follow_up'    => true,
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        return redirect()->route('admin.settings.index')
            ->with('success', 'Impostazioni salvate con successo.');
    }
}