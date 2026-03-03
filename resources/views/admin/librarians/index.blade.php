@extends('layouts.admin')
@section('title', 'Bibliotecari')

@section('content')
<div class="space-y-5">
    <form method="GET" class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-medium text-gray-500 mb-1">Cerca</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Nome, email, reparto..."
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Ruolo</label>
            <select name="role" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                <option value="">Tutti i ruoli</option>
                @foreach($roles as $key => $meta)
                <option value="{{ $key }}" {{ $role == $key ? 'selected' : '' }}>{{ $meta['label'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-teal-700 transition-colors">
            <i class="fas fa-search mr-1"></i>Filtra
        </button>
        @if($search || $role)
            <a href="{{ route('admin.librarians.index') }}" class="px-3 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-600">✕ Reset</a>
        @endif
        <a href="{{ route('admin.librarians.create') }}" class="ml-auto inline-flex items-center space-x-2 bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <i class="fas fa-plus"></i><span>Aggiungi Bibliotecario</span>
        </a>
    </form>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominativo</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reparto</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ruolo</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stato</th>
                    <th class="px-5 py-3 text-right text-xs font-medium text-gray-500 uppercase">Azioni</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($librarians as $lib)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-teal-100 text-teal-700 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($lib->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $lib->name }}</p>
                                <p class="text-xs text-gray-400">{{ $lib->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-600 font-mono text-xs">{{ $lib->employee_id }}</td>
                    <td class="px-5 py-3 text-gray-600 text-xs">{{ $lib->department }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $lib->role_color }}">
                            {{ $lib->role_label }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $lib->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $lib->active ? 'Attivo' : 'Inattivo' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.librarians.show', $lib->id) }}" class="text-gray-400 hover:text-teal-600 transition-colors" title="Dettaglio">
                                <i class="fas fa-eye"></i>
                            </a>
                            <!-- Quick role edit inline form -->
                            <button type="button" onclick="toggleRoleForm({{ $lib->id }})" class="text-gray-400 hover:text-purple-600 transition-colors" title="Modifica Ruolo">
                                <i class="fas fa-user-tag"></i>
                            </button>
                            <a href="{{ route('admin.librarians.edit', $lib->id) }}" class="text-gray-400 hover:text-blue-600 transition-colors" title="Modifica">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.librarians.destroy', $lib->id) }}" method="POST" class="inline" onsubmit="return confirm('Eliminare questo bibliotecario?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Elimina"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                        <!-- Inline quick-role form (hidden by default) -->
                        <div id="role-form-{{ $lib->id }}" class="hidden mt-2">
                            <form action="{{ route('admin.librarians.updateRole', $lib->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="role" class="border border-gray-300 rounded-lg px-2 py-1 text-xs focus:ring-2 focus:ring-purple-400 outline-none">
                                    @foreach($roles as $key => $meta)
                                    <option value="{{ $key }}" {{ $lib->role == $key ? 'selected' : '' }}>{{ $meta['label'] }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-purple-600 text-white px-2 py-1 rounded text-xs hover:bg-purple-700">Salva</button>
                                <button type="button" onclick="toggleRoleForm({{ $lib->id }})" class="text-gray-400 text-xs hover:text-gray-600">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400"><i class="fas fa-users text-3xl mb-2 block"></i>Nessun bibliotecario trovato.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3 border-t border-gray-100">{{ $librarians->links() }}</div>
    </div>
</div>

<script>
function toggleRoleForm(id) {
    const el = document.getElementById('role-form-' + id);
    el.classList.toggle('hidden');
}
</script>
@endsection
