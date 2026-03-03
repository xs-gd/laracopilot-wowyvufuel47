@extends('layouts.admin')
@section('title', 'Report')
@section('page-title', 'Generazione Report')
@section('page-subtitle', 'Crea report personalizzati sulle transazioni di riferimento')

@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6"><i class="fas fa-filter text-indigo-500 mr-2"></i>Parametri del Report</h3>

    <form action="{{ route('admin.reports.generate') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Inizio <span class="text-red-500">*</span></label>
                <input type="date" name="date_from" value="{{ old('date_from', date('Y-m-01')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 @error('date_from') border-red-400 @enderror" required>
                @error('date_from')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Fine <span class="text-red-500">*</span></label>
                <input type="date" name="date_to" value="{{ old('date_to', date('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 @error('date_to') border-red-400 @enderror" required>
                @error('date_to')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Report <span class="text-red-500">*</span></label>
                <select name="report_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500" required>
                    <option value="summary" {{ old('report_type') == 'summary' ? 'selected' : '' }}>Riepilogo Statistico</option>
                    <option value="detail" {{ old('report_type') == 'detail' ? 'selected' : '' }}>Dettaglio Completo</option>
                    <option value="librarian" {{ old('report_type') == 'librarian' ? 'selected' : '' }}>Per Bibliotecario</option>
                    <option value="subject" {{ old('report_type') == 'subject' ? 'selected' : '' }}>Per Area Tematica</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bibliotecario (opzionale)</label>
                <select name="librarian_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Tutti i bibliotecari</option>
                    @foreach($librarians as $lib)
                        <option value="{{ $lib->id }}" {{ old('librarian_id') == $lib->id ? 'selected' : '' }}>{{ $lib->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-semibold text-sm hover:bg-indigo-700 transition">
            <i class="fas fa-chart-bar mr-2"></i>Genera Report
        </button>
    </form>
</div>
</div>
@endsection
