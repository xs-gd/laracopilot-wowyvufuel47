@extends('layouts.admin')
@section('title', 'Modifica Bibliotecario')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.librarians.index') }}" class="text-sm text-teal-600 hover:text-teal-800"><i class="fas fa-arrow-left mr-1"></i>Torna alla lista</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-semibold text-gray-800">Modifica: {{ $librarian->name }}</h2>
            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $librarian->role_color }}">{{ $librarian->role_label }}</span>
        </div>
        <form action="{{ route('admin.librarians.update', $librarian->id) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                    <input type="text" name="name" value="{{ old('name', $librarian->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $librarian->email) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Dipendente *</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $librarian->employee_id) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none @error('employee_id') border-red-400 @enderror">
                    @error('employee_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reparto *</label>
                    <input type="text" name="department" value="{{ old('department', $librarian->department) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none @error('department') border-red-400 @enderror">
                    @error('department')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Specializzazione</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $librarian->specialization) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefono</label>
                    <input type="text" name="phone" value="{{ old('phone', $librarian->phone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Assunzione *</label>
                    <input type="date" name="hire_date" value="{{ old('hire_date', $librarian->hire_date->format('Y-m-d')) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div class="flex items-center mt-5">
                    <input type="hidden" name="active" value="0">
                    <input type="checkbox" name="active" id="active" value="1" {{ old('active', $librarian->active) ? 'checked' : '' }} class="w-4 h-4 text-teal-600 border-gray-300 rounded">
                    <label for="active" class="ml-2 text-sm text-gray-700">Dipendente Attivo</label>
                </div>
            </div>

            <!-- Role Section -->
            <div class="border-t border-gray-100 pt-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3"><i class="fas fa-user-tag text-purple-500 mr-1"></i>Ruolo e Responsabilità</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ruolo *</label>
                        <select name="role" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-400 outline-none">
                            @foreach($roles as $key => $meta)
                            <option value="{{ $key }}" {{ old('role', $librarian->role) == $key ? 'selected' : '' }}>{{ $meta['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Note sul Ruolo</label>
                        <input type="text" name="role_notes" value="{{ old('role_notes', $librarian->role_notes) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-400 outline-none">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <a href="{{ route('admin.librarians.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm hover:bg-gray-50">Annulla</a>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm hover:bg-teal-700 font-medium">Aggiorna</button>
            </div>
        </form>
    </div>
</div>
@endsection
