@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Totale Transazioni</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTransactions }}</p>
                </div>
                <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exchange-alt text-teal-500 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">In Attesa</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingTransactions }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-400 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Chiuse</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $closedTransactions }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Bibliotecari Attivi</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $activeLibrarians }}<span class="text-sm text-gray-400 font-normal">/{{ $totalLibrarians }}</span></p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-blue-500 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- By Channel -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-chart-bar text-teal-500 mr-2"></i>Transazioni per Canale</h3>
            <div class="space-y-3">
                @php
                    $channelLabels = ['in_person'=>'Di Persona','phone'=>'Telefono','email'=>'Email','chat'=>'Chat','virtual'=>'Virtuale'];
                    $channelColors = ['in_person'=>'bg-teal-500','phone'=>'bg-blue-500','email'=>'bg-purple-500','chat'=>'bg-orange-500','virtual'=>'bg-pink-500'];
                    $maxCh = $transactionsByChannel->max('total') ?: 1;
                @endphp
                @foreach($transactionsByChannel as $row)
                <div>
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>{{ $channelLabels[$row->channel] ?? $row->channel }}</span>
                        <span class="font-semibold">{{ $row->total }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="{{ $channelColors[$row->channel] ?? 'bg-gray-400' }} h-2 rounded-full" style="width: {{ round(($row->total / $maxCh) * 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- By Type -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-chart-pie text-teal-500 mr-2"></i>Transazioni per Tipo</h3>
            <div class="space-y-3">
                @php
                    $typeLabels = ['ready_reference'=>'Riferimento Rapido','research'=>'Ricerca','directional'=>'Orientamento','instructional'=>'Formativo','reader_advisory'=>'Consulenza','technical'=>'Tecnico'];
                    $maxTy = $transactionsByType->max('total') ?: 1;
                @endphp
                @foreach($transactionsByType as $row)
                <div>
                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                        <span>{{ $typeLabels[$row->transaction_type] ?? $row->transaction_type }}</span>
                        <span class="font-semibold">{{ $row->total }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-teal-400 h-2 rounded-full" style="width: {{ round(($row->total / $maxTy) * 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-700"><i class="fas fa-history text-teal-500 mr-2"></i>Transazioni Recenti</h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-xs text-teal-600 hover:text-teal-800 font-medium">Vedi tutte →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bibliotecario</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Argomento</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Canale</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stato</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentTransactions as $t)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-gray-600">{{ $t->transaction_date->format('d/m/Y') }}</td>
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $t->librarian->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ Str::limit($t->subject_area, 30) }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ ['in_person'=>'Di Persona','phone'=>'Telefono','email'=>'Email','chat'=>'Chat','virtual'=>'Virtuale'][$t->channel] ?? $t->channel }}</td>
                        <td class="px-5 py-3">
                            @php $sc = ['pending'=>'bg-yellow-100 text-yellow-800','in_progress'=>'bg-blue-100 text-blue-800','closed'=>'bg-green-100 text-green-800','referred'=>'bg-purple-100 text-purple-800']; @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $sc[$t->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ['pending'=>'In Attesa','in_progress'=>'In Corso','closed'=>'Chiuso','referred'=>'Inoltrato'][$t->status] ?? $t->status }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
