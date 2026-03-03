@extends('layouts.admin')
@section('title', 'Statistiche')
@section('page-title', 'Statistiche')
@section('page-subtitle', 'Analisi quantitativa delle transazioni di riferimento')

@section('content')

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Anno</label>
            <select name="year" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                @foreach($availableYears as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mese (opzionale)</label>
            <select name="month" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Tutti i mesi</option>
                @foreach(['01'=>'Gennaio','02'=>'Febbraio','03'=>'Marzo','04'=>'Aprile','05'=>'Maggio','06'=>'Giugno','07'=>'Luglio','08'=>'Agosto','09'=>'Settembre','10'=>'Ottobre','11'=>'Novembre','12'=>'Dicembre'] as $k=>$v)
                    <option value="{{ $k }}" {{ $month == $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">Applica Filtri</button>
    </form>
</div>

<!-- KPIs -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 text-center border-t-4 border-indigo-500">
        <p class="text-3xl font-bold text-indigo-700">{{ number_format($total) }}</p>
        <p class="text-gray-500 text-sm mt-1">Transazioni Totali</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 text-center border-t-4 border-emerald-500">
        <p class="text-3xl font-bold text-emerald-700">{{ $avgDuration }} min</p>
        <p class="text-gray-500 text-sm mt-1">Durata Media</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 text-center border-t-4 border-orange-500">
        <p class="text-3xl font-bold text-orange-700">{{ $followUpRequired }}</p>
        <p class="text-gray-500 text-sm mt-1">Follow-up Richiesti</p>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-layer-group text-indigo-500 mr-1"></i> Per Tipo</h3>
        @foreach($byType as $item)
        <div class="mb-2">
            <div class="flex justify-between text-xs mb-1">
                <span class="text-gray-600 truncate">{{ ucfirst(str_replace('_', ' ', $item->transaction_type)) }}</span>
                <span class="font-semibold text-gray-800">{{ $item->total }}</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $total > 0 ? round($item->total/$total*100) : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-wifi text-blue-500 mr-1"></i> Per Canale</h3>
        @foreach($byChannel as $item)
        <div class="mb-2">
            <div class="flex justify-between text-xs mb-1">
                <span class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $item->channel)) }}</span>
                <span class="font-semibold text-gray-800">{{ $item->total }}</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $total > 0 ? round($item->total/$total*100) : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-brain text-violet-500 mr-1"></i> Per Complessità</h3>
        @foreach($byComplexity as $item)
        <div class="mb-3">
            <div class="flex justify-between text-xs mb-1">
                <span class="text-gray-600">{{ ucfirst($item->complexity_level) }}</span>
                <span class="font-semibold">{{ $item->total }} ({{ $total > 0 ? round($item->total/$total*100) : 0 }}%)</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="h-2 rounded-full
                    @if($item->complexity_level === 'complex') bg-red-400
                    @elseif($item->complexity_level === 'moderate') bg-amber-400
                    @else bg-green-400 @endif" style="width: {{ $total > 0 ? round($item->total/$total*100) : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-tasks text-emerald-500 mr-1"></i> Per Stato</h3>
        @foreach($byStatus as $item)
        <div class="mb-2">
            <div class="flex justify-between text-xs mb-1">
                <span class="text-gray-600">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span>
                <span class="font-semibold text-gray-800">{{ $item->total }}</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $total > 0 ? round($item->total/$total*100) : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Monthly trend + top subjects -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-chart-area text-indigo-500 mr-1"></i> Andamento Mensile {{ $year }}</h3>
        <canvas id="monthlyChart" height="120"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <h3 class="text-sm font-semibold text-gray-700 mb-4"><i class="fas fa-book text-indigo-500 mr-1"></i> Top Aree Tematiche</h3>
        @foreach($bySubject as $index => $item)
        <div class="flex items-center gap-3 mb-2">
            <span class="w-4 text-xs text-gray-400 text-right">{{ $index+1 }}</span>
            <div class="flex-1">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-gray-700 truncate">{{ $item->subject_area }}</span>
                    <span class="font-semibold ml-2">{{ $item->total }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-violet-400 h-1.5 rounded-full" style="width: {{ $bySubject->first() ? round($item->total/$bySubject->first()->total*100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script>
new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'],
        datasets: [{
            label: 'Transazioni',
            data: [{{ implode(',', array_values($months)) }}],
            borderColor: 'rgb(99,102,241)',
            backgroundColor: 'rgba(99,102,241,0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgb(99,102,241)',
            pointRadius: 4,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endpush
