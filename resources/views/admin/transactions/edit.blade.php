@extends('layouts.admin')
@section('title', 'Modifica Transazione')

@section('content')
<div class="max-w-3xl">
    <div class="mb-4">
        <a href="{{ route('admin.transactions.index') }}" class="text-sm text-teal-600 hover:text-teal-800"><i class="fas fa-arrow-left mr-1"></i>Torna alla lista</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-5">Modifica Transazione #{{ $transaction->id }}</h2>
        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data *</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ora *</label>
                    <input type="time" name="transaction_time" value="{{ old('transaction_time', substr($transaction->transaction_time, 0, 5)) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bibliotecario *</label>
                    <select name="librarian_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach($librarians as $lib)
                        <option value="{{ $lib->id }}" {{ old('librarian_id', $transaction->librarian_id) == $lib->id ? 'selected' : '' }}>{{ $lib->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Utente *</label>
                    <input type="text" name="patron_type" value="{{ old('patron_type', $transaction->patron_type) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Canale *</label>
                    <select name="channel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach(['in_person'=>'Di Persona','phone'=>'Telefono','email'=>'Email','chat'=>'Chat','virtual'=>'Virtuale'] as $val => $label)
                        <option value="{{ $val }}" {{ old('channel', $transaction->channel) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Transazione *</label>
                    <select name="transaction_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach(['ready_reference'=>'Riferimento Rapido','research'=>'Ricerca','directional'=>'Orientamento','instructional'=>'Formativo','reader_advisory'=>'Consulenza Lettore','technical'=>'Tecnico'] as $val => $label)
                        <option value="{{ $val }}" {{ old('transaction_type', $transaction->transaction_type) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stato *</label>
                    <select name="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach(['pending'=>'In Attesa','in_progress'=>'In Corso','closed'=>'Chiuso','referred'=>'Inoltrato'] as $val => $label)
                        <option value="{{ $val }}" {{ old('status', $transaction->status) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Complessità *</label>
                    <select name="complexity_level" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach(['simple'=>'Semplice','moderate'=>'Moderato','complex'=>'Complesso'] as $val => $label)
                        <option value="{{ $val }}" {{ old('complexity_level', $transaction->complexity_level) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Area Tematica *</label>
                    <input type="text" name="subject_area" value="{{ old('subject_area', $transaction->subject_area) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durata (minuti)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $transaction->duration_minutes) }}" min="1" max="480" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Riepilogo Domanda *</label>
                <textarea name="question_summary" required rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">{{ old('question_summary', $transaction->question_summary) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Risposta Fornita</label>
                <textarea name="response_summary" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">{{ old('response_summary', $transaction->response_summary) }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Risorse Utilizzate</label>
                    <input type="text" name="resources_used" value="{{ old('resources_used', $transaction->resources_used) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                    <input type="text" name="notes" value="{{ old('notes', $transaction->notes) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <input type="hidden" name="follow_up_required" value="0">
                <input type="checkbox" name="follow_up_required" id="follow_up" value="1" {{ old('follow_up_required', $transaction->follow_up_required) ? 'checked' : '' }} class="w-4 h-4 text-teal-600 border-gray-300 rounded">
                <label for="follow_up" class="text-sm text-gray-700">Richiede Follow-up</label>
            </div>
            <div class="flex justify-end space-x-3 pt-2">
                <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">Annulla</a>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm hover:bg-teal-700 font-medium">Aggiorna</button>
            </div>
        </form>
    </div>
</div>
@endsection
