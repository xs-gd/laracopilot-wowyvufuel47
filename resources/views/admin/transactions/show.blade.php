@extends('layouts.admin')
@section('title', 'Dettaglio Transazione')

@section('content')
<div class="max-w-3xl space-y-5">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.transactions.index') }}" class="text-sm text-teal-600 hover:text-teal-800"><i class="fas fa-arrow-left mr-1"></i>Torna alla lista</a>
        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="inline-flex items-center space-x-2 bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg text-sm"><i class="fas fa-edit"></i><span>Modifica</span></a>
    </div>

    @php
        $statusColors = ['pending'=>'bg-yellow-100 text-yellow-800','in_progress'=>'bg-blue-100 text-blue-800','closed'=>'bg-green-100 text-green-800','referred'=>'bg-purple-100 text-purple-800'];
        $statusLabels = ['pending'=>'In Attesa','in_progress'=>'In Corso','closed'=>'Chiuso','referred'=>'Inoltrato'];
        $channelLabels = ['in_person'=>'Di Persona','phone'=>'Telefono','email'=>'Email','chat'=>'Chat','virtual'=>'Virtuale'];
        $typeLabels = ['ready_reference'=>'Riferimento Rapido','research'=>'Ricerca','directional'=>'Orientamento','instructional'=>'Formativo','reader_advisory'=>'Consulenza Lettore','technical'=>'Tecnico'];
        $complexLabels = ['simple'=>'Semplice','moderate'=>'Moderato','complex'=>'Complesso'];
    @endphp

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800">{{ $transaction->subject_area }}</h2>
                <p class="text-sm text-gray-500 mt-1">Transazione #{{ $transaction->id }} · {{ $transaction->transaction_date->format('d/m/Y') }} alle {{ substr($transaction->transaction_time, 0, 5) }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-700' }}">{{ $statusLabels[$transaction->status] ?? $transaction->status }}</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm mb-5">
            <div><p class="text-xs text-gray-400 uppercase">Bibliotecario</p><p class="text-gray-700 mt-0.5 font-medium">{{ $transaction->librarian->name ?? '—' }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Tipo Utente</p><p class="text-gray-700 mt-0.5">{{ $transaction->patron_type }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Canale</p><p class="text-gray-700 mt-0.5">{{ $channelLabels[$transaction->channel] ?? $transaction->channel }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Tipo</p><p class="text-gray-700 mt-0.5">{{ $typeLabels[$transaction->transaction_type] ?? $transaction->transaction_type }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Complessità</p><p class="text-gray-700 mt-0.5">{{ $complexLabels[$transaction->complexity_level] ?? $transaction->complexity_level }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Durata</p><p class="text-gray-700 mt-0.5">{{ $transaction->duration_minutes ? $transaction->duration_minutes . ' min' : '—' }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Follow-up</p><p class="mt-0.5"><span class="px-2 py-0.5 rounded text-xs {{ $transaction->follow_up_required ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-500' }}">{{ $transaction->follow_up_required ? 'Richiesto' : 'No' }}</span></p></div>
            <div><p class="text-xs text-gray-400 uppercase">Registrato da</p><p class="text-gray-700 mt-0.5">{{ $transaction->recorded_by ?? '—' }}</p></div>
        </div>
        <div class="space-y-4">
            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Riepilogo Domanda</p>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3 leading-relaxed">{{ $transaction->question_summary }}</p>
            </div>
            @if($transaction->response_summary)
            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Risposta Fornita</p>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3 leading-relaxed">{{ $transaction->response_summary }}</p>
            </div>
            @endif
            @if($transaction->resources_used)
            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Risorse Utilizzate</p>
                <p class="text-sm text-gray-700">{{ $transaction->resources_used }}</p>
            </div>
            @endif
            @if($transaction->notes)
            <div>
                <p class="text-xs text-gray-400 uppercase font-medium mb-1">Note</p>
                <p class="text-sm text-gray-700">{{ $transaction->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
