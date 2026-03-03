@extends('layouts.admin')
@section('title', 'Nuova Transazione')

@section('content')
<div class="max-w-3xl">
    <div class="mb-4">
        <a href="{{ route('admin.transactions.index') }}" class="text-sm text-teal-600 hover:text-teal-800"><i class="fas fa-arrow-left mr-1"></i>Torna alla lista</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-5">Registra Nuova Transazione</h2>
        <form action="{{ route('admin.transactions.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data *</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ora *</label>
                    <input type="time" name="transaction_time" value="{{ old('transaction_time', date('H:i')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bibliotecario *</label>
                    <select name="librarian_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none @error('librarian_id') border-red-400 @enderror">
                        <option value="">Seleziona...</option>
                        @foreach($librarians as $lib)
                        <option value="{{ $lib->id }}" {{ old('librarian_id') == $lib->id ? 'selected' : '' }}>{{ $lib->name }}</option>
                        @endforeach
                    </select>
                    @error('librarian_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Utente *</label>
                    <input type="text" name="patron_type" value="{{ old('patron_type') }}" required placeholder="es. Studente Magistrale" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Canale *</label>
                    <select name="channel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Seleziona...</option>
                        <option value="in_person" {{ old('channel')=='in_person'?'selected':'' }}>Di Persona</option>
                        <option value="phone" {{ old('channel')=='phone'?'selected':'' }}>Telefono</option>
                        <option value="email" {{ old('channel')=='email'?'selected':'' }}>Email</option>
                        <option value="chat" {{ old('channel')=='chat'?'selected':'' }}>Chat</option>
                        <option value="virtual" {{ old('channel')=='virtual'?'selected':'' }}>Virtuale</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Transazione *</label>
                    <select name="transaction_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Seleziona...</option>
                        <option value="ready_reference" {{ old('transaction_type')=='ready_reference'?'selected':'' }}>Riferimento Rapido</option>
                        <option value="research" {{ old('transaction_type')=='research'?'selected':'' }}>Ricerca</option>
                        <option value="directional" {{ old('transaction_type')=='directional'?'selected':'' }}>Orientamento</option>
                        <option value="instructional" {{ old('transaction_type')=='instructional'?'selected':'' }}>Formativo</option>
                        <option value="reader_advisory" {{ old('transaction_type')=='reader_advisory'?'selected':'' }}>Consulenza Lettore</option>
                        <option value="technical" {{ old('transaction_type')=='technical'?'selected':'' }}>Tecnico</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stato *</label>
                    <select name="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="pending" {{ old('status','pending')=='pending'?'selected':'' }}>In Attesa</option>
                        <option value="in_progress" {{ old('status')=='in_progress'?'selected':'' }}>In Corso</option>
                        <option value="closed" {{ old('status')=='closed'?'selected':'' }}>Chiuso</option>
                        <option value="referred" {{ old('status')=='referred'?'selected':'' }}>Inoltrato</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Complessità *</label>
                    <select name="complexity_level" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="simple" {{ old('complexity_level','simple')=='simple'?'selected':'' }}>Semplice</option>
                        <option value="moderate" {{ old('complexity_level')=='moderate'?'selected':'' }}>Moderato</option>
                        <option value="complex" {{ old('complexity_level')=='complex'?'selected':'' }}>Complesso</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Area Tematica *</label>
                    <input type="text" name="subject_area" value="{{ old('subject_area') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durata (minuti)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1" max="480" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Riepilogo Domanda *</label>
                <textarea name="question_summary" required rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">{{ old('question_summary') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Risposta Fornita</label>
                <textarea name="response_summary" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">{{ old('response_summary') }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Risorse Utilizzate</label>
                    <input type="text" name="resources_used" value="{{ old('resources_used') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <input type="hidden" name="follow_up_required" value="0">
                <input type="checkbox" name="follow_up_required" id="follow_up" value="1" {{ old('follow_up_required') ? 'checked' : '' }} class="w-4 h-4 text-teal-600 border-gray-300 rounded">
                <label for="follow_up" class="text-sm text-gray-700">Richiede Follow-up</label>
            </div>
            <div class="flex justify-end space-x-3 pt-2">
                <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">Annulla</a>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm hover:bg-teal-700 font-medium">Registra Transazione</button>
            </div>
        </form>
    </div>
</div>
@endsection
