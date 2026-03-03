@extends('layouts.admin')
@section('title', 'Transazioni di Riferimento')

@section('content')
<div class="space-y-5">
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cerca</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Argomento, domanda, utente..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Stato</label>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                <option value="">Tutti</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>In Attesa</option>
                <option value="in_progress" {{ $status == 'in_progress' ? 'selected' : '' }}>In Corso</option>
                <option value="closed" {{ $status == 'closed' ? 'selected' : '' }}>Chiuso</option>
                <option value="referred" {{ $status == 'referred' ? 'selected' : '' }}>Inoltrato</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Canale</label>
            <select name="channel" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                <option value="">Tutti</option>
                <option value="in_person" {{ $channel == 'in_person' ? 'selected' : '' }}>Di Persona</option>
                <option value="phone" {{ $channel == 'phone' ? 'selected' : '' }}>Telefono</option>
                <option value="email" {{ $channel == 'email' ? 'selected' : '' }}>Email</option>
                <option value="chat" {{ $channel == 'chat' ? 'selected' : '' }}>Chat</option>
                <option value="virtual" {{ $channel == 'virtual' ? 'selected' : '' }}>Virtuale</option>
            </select>
        </div>
        <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-teal-700"><i class="fas fa-search mr-1"></i>Filtra</button>
        @if($search || $status || $channel)<a href="{{ route('admin.transactions.index') }}" class="px-3 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-600">✕ Reset</a>@endif
        <a href="{{ route('admin.transactions.create') }}" class="ml-auto inline-flex items-center space-x-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
            <i class="fas fa-plus"></i><span>Nuova Transazione</span>
        </a>
    </form>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bibliotecario</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Argomento</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Canale</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Complessità</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stato</th>
                    <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Azioni</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transactions as $t)
                @php
                    $statusColors = ['pending'=>'bg-yellow-100 text-yellow-800','in_progress'=>'bg-blue-100 text-blue-800','closed'=>'bg-green-100 text-green-800','referred'=>'bg-purple-100 text-purple-800'];
                    $statusLabels = ['pending'=>'In Attesa','in_progress'=>'In Corso','closed'=>'Chiuso','referred'=>'Inoltrato'];
                    $complexColors = ['simple'=>'bg-gray-100 text-gray-600','moderate'=>'bg-orange-100 text-orange-700','complex'=>'bg-red-100 text-red-700'];
                    $complexLabels = ['simple'=>'Semplice','moderate'=>'Moderato','complex'=>'Complesso'];
                    $channelLabels = ['in_person'=>'Di Persona','phone'=>'Telefono','email'=>'Email','chat'=>'Chat','virtual'=>'Virtuale'];
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-600 whitespace-nowrap">{{ $t->transaction_date->format('d/m/Y') }}</td>
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $t->librarian->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ Str::limit($t->subject_area, 35) }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $channelLabels[$t->channel] ?? $t->channel }}</td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $complexColors[$t->complexity_level] ?? '' }}">{{ $complexLabels[$t->complexity_level] ?? $t->complexity_level }}</span></td>
                    <td class="px-5 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$t->status] ?? '' }}">{{ $statusLabels[$t->status] ?? $t->status }}</span></td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.transactions.show', $t->id) }}" class="text-gray-400 hover:text-teal-600"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.transactions.edit', $t->id) }}" class="text-gray-400 hover:text-blue-600"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.transactions.destroy', $t->id) }}" method="POST" class="inline" onsubmit="return confirm('Eliminare questa transazione?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-gray-400"><i class="fas fa-exchange-alt text-3xl mb-2 block"></i>Nessuna transazione trovata.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-gray-100">{{ $transactions->links() }}</div>
    </div>
</div>
@endsection
