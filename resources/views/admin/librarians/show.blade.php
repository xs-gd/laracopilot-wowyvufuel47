@extends('layouts.admin')
@section('title', $librarian->name)

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.librarians.index') }}" class="text-sm text-teal-600 hover:text-teal-800"><i class="fas fa-arrow-left mr-1"></i>Torna alla lista</a>
        <a href="{{ route('admin.librarians.edit', $librarian->id) }}" class="inline-flex items-center space-x-2 bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-lg text-sm">
            <i class="fas fa-edit"></i><span>Modifica</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-14 h-14 bg-teal-100 text-teal-700 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                {{ strtoupper(substr($librarian->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold text-gray-800">{{ $librarian->name }}</h2>
                <p class="text-sm text-gray-500">{{ $librarian->employee_id }} · {{ $librarian->department }}</p>
                <div class="flex items-center gap-2 mt-2 flex-wrap">
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $librarian->role_color }}">
                        <i class="fas fa-user-tag mr-1"></i>{{ $librarian->role_label }}
                    </span>
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $librarian->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $librarian->active ? 'Attivo' : 'Inattivo' }}
                    </span>
                </div>
                @if($librarian->role_notes)
                <p class="text-xs text-gray-500 mt-2 italic">{{ $librarian->role_notes }}</p>
                @endif
            </div>

            <!-- Quick role change on show page -->
            <div class="flex-shrink-0">
                <button type="button" onclick="document.getElementById('quick-role-panel').classList.toggle('hidden')" class="inline-flex items-center space-x-1 border border-purple-300 text-purple-600 hover:bg-purple-50 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                    <i class="fas fa-sync-alt"></i><span>Cambia Ruolo</span>
                </button>
            </div>
        </div>

        <!-- Quick role panel -->
        <div id="quick-role-panel" class="hidden border border-purple-200 bg-purple-50 rounded-lg p-4 mb-4">
            <p class="text-xs font-semibold text-purple-700 uppercase mb-3">Aggiornamento Rapido Ruolo</p>
            <form action="{{ route('admin.librarians.updateRole', $librarian->id) }}" method="POST" class="flex flex-wrap items-end gap-3">
                @csrf @method('PATCH')
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nuovo Ruolo</label>
                    <select name="role" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-400 outline-none">
                        @foreach(App\Models\Librarian::roles() as $key => $meta)
                        <option value="{{ $key }}" {{ $librarian->role == $key ? 'selected' : '' }}>{{ $meta['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-48">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Note (opzionale)</label>
                    <input type="text" name="role_notes" value="{{ $librarian->role_notes }}" placeholder="Aggiungi note sul ruolo..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-400 outline-none">
                </div>
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 font-medium">Aggiorna Ruolo</button>
            </form>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
            <div><p class="text-xs text-gray-400 uppercase">Email</p><p class="text-gray-700 mt-0.5">{{ $librarian->email }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Telefono</p><p class="text-gray-700 mt-0.5">{{ $librarian->phone ?? '—' }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Specializzazione</p><p class="text-gray-700 mt-0.5">{{ $librarian->specialization ?? '—' }}</p></div>
            <div><p class="text-xs text-gray-400 uppercase">Assunto il</p><p class="text-gray-700 mt-0.5">{{ $librarian->hire_date->format('d/m/Y') }}</p></div>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-4 text-center"><p class="text-2xl font-bold text-teal-600">{{ $stats['total'] }}</p><p class="text-xs text-gray-500 mt-1">Totale Transazioni</p></div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center"><p class="text-2xl font-bold text-green-600">{{ $stats['closed'] }}</p><p class="text-xs text-gray-500 mt-1">Chiuse</p></div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center"><p class="text-2xl font-bold text-yellow-500">{{ $stats['pending'] }}</p><p class="text-xs text-gray-500 mt-1">In Attesa</p></div>
        <div class="bg-white rounded-xl shadow-sm p-4 text-center"><p class="text-2xl font-bold text-blue-600">{{ $stats['avg_duration'] }}'</p><p class="text-xs text-gray-500 mt-1">Durata Media</p></div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100"><h3 class="text-sm font-semibold text-gray-700">Ultime Transazioni</h3></div>
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Argomento</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stato</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($librarian->transactions as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-600">{{ $t->transaction_date->format('d/m/Y') }}</td>
                    <td class="px-5 py-3 text-gray-800">{{ Str::limit($t->subject_area, 40) }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ ['ready_reference'=>'Rif. Rapido','research'=>'Ricerca','directional'=>'Orientamento','instructional'=>'Formativo','reader_advisory'=>'Consulenza','technical'=>'Tecnico'][$t->transaction_type] ?? $t->transaction_type }}</td>
                    <td class="px-5 py-3">
                        @php $sc = ['pending'=>'bg-yellow-100 text-yellow-800','in_progress'=>'bg-blue-100 text-blue-800','closed'=>'bg-green-100 text-green-800','referred'=>'bg-purple-100 text-purple-800']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sc[$t->status] ?? 'bg-gray-100 text-gray-700' }}">{{ ['pending'=>'In Attesa','in_progress'=>'In Corso','closed'=>'Chiuso','referred'=>'Inoltrato'][$t->status] ?? $t->status }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400 text-sm">Nessuna transazione registrata.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
