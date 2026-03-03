@extends('layouts.admin')
@section('title', 'Impostazioni')
@section('page-title', 'Impostazioni Sistema')
@section('page-subtitle', 'Configurazione dell\'applicazione')

@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf @method('PUT')
        <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wider mb-4">Configurazione Biblioteca</h3>
        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nome Biblioteca</label>
                <input type="text" name="library_name" value="{{ $settings['library_name'] }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email di Contatto</label>
                <input type="email" name="contact_email" value="{{ $settings['contact_email'] }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fuso Orario</label>
                <select name="timezone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="Europe/Rome" selected>Europe/Rome (UTC+1/+2)</option>
                    <option value="UTC">UTC</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Record per Pagina</label>
                <select name="records_per_page" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="10" {{ $settings['records_per_page'] == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $settings['records_per_page'] == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $settings['records_per_page'] == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-gray-100">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                <i class="fas fa-save mr-1"></i>Salva Impostazioni
            </button>
        </div>
    </form>
</div>

<!-- System info -->
<div class="bg-white rounded-xl shadow-sm p-6 mt-5">
    <h3 class="text-sm font-semibold text-gray-700 mb-4">Informazioni di Sistema</h3>
    <div class="space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-gray-500">Versione Laravel</span><span class="font-medium">{{ app()->version() }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">PHP</span><span class="font-medium">{{ PHP_VERSION }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Database</span><span class="font-medium">SQLite</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Utente corrente</span><span class="font-medium">{{ session('admin_user') }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Ruolo</span><span class="font-medium capitalize">{{ session('admin_role') }}</span></div>
    </div>
</div>
</div>
@endsection
