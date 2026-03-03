@extends('layouts.admin')
@section('title', 'Risultato Report')
@section('page-title', 'Report Generato')
@section('page-subtitle', 'Risultati per il periodo selezionato')

@section('content')

<div class="flex justify-between items-center mb-5">
    <a href="{{ route('admin.reports.index') }}" class="text-indigo-600 text-sm hover:underline">
        <i class="fas fa-arrow-left mr-1"></i>Nuovo Report
    </a>
    <button onclick="window.print()" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition">
        <i class="fas fa-print mr-1"></i>Stampa
    </button>
</div>

<!-- Summary header -->
<div class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-xl p-6 text-white mb-6">
    <h2 class="text-xl font-bold mb-1">Report Transazioni di Riferimento</h2>
    <p class="text-indigo-200 text-sm">Periodo: {{ \Carbon\Carbon::parse($request->date_from)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($request->date_to)->format('d/m/Y') }}</p>
    <p class="text-indigo-200 text-sm">Tipo: {{ ucfirst($request->report_type) }} · Generato il: {{ now()->format('d/m/Y H:i') }}</p>
</div>

<!-- KPI Summary -->
<div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-7 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-indigo-700">{{ $summary['total'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Totale</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-emerald-700">{{ $summary['avg_duration'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Min Medi</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-orange-700">{{ $summary['follow_ups'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Follow-up</p>
    </div>
    @foreach($summary['by_status'] as $status => $count)
    <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-gray-700">{{ $count }}</p>
        <p class="text-xs text-gray-500 mt-1">{{ ucfirst(str_replace('_',' ',$status)) }}</p>
    </div>
    @endforeach
</div>

<!-- Breakdowns -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4">Per Tipo di Transazione</h3>
        @foreach($summary['by_type'] as $type => $count)
        <div class="flex justify-between items-center py-1.5 border-b border-gray-50 last:border-0">
            <span class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
            <span class="text-sm font-semibold text-gray-800">{{ $count }}</span>
        </div>
        @endforeach
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="font-semibold text-gray-700 mb-4">Per Canale</h3>
        @foreach($summary['by_channel'] as $channel => $count)
        <div class="flex justify-between items-center py-1.5 border-b border-gray-50 last:border-0">
            <span class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $channel)) }}</span>
            <span class="text-sm font-semibold text-gray-800">{{ $count }}</span>
        </div>
        @endforeach
    </div>
</div>

<!-- Detail table -->
@if($request->report_type === 'detail')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-5 border-b border-gray-100">
        <h3 class="font-semibold text-gray-700">Dettaglio Transazioni ({{ $transactions->count() }})</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Data</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Bibliotecario</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Area</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Tipo</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Canale</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Stato</th>
                    <th class="px-4 py-2 text-left text-xs text-gray-500 uppercase">Durata</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($transactions as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $t->transaction_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $t->librarian->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2 max-w-xs truncate">{{ $t->subject_area }}</td>
                    <td class="px-4 py-2">{{ $t->type_label }}</td>
                    <td class="px-4 py-2">{{ $t->channel_label }}</td>
                    <td class="px-4 py-2">{{ $t->status_label }}</td>
                    <td class="px-4 py-2">{{ $t->duration_minutes ? $t->duration_minutes . ' min' : 'N/D' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
