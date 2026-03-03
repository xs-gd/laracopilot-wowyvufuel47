@extends('layouts.admin')

@section('page-title')
    <h2 class="text-xl font-semibold text-gray-800">Librarians</h2>
@endsection

@section('content')

<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Manage library staff records.</p>
    <a href="{{ route('admin.librarians.create') }}"
       class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow">
        <i class="fas fa-plus mr-2"></i>Add Librarian
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Department</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($librarians as $librarian)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-teal-100 rounded-full w-9 h-9 flex items-center justify-center flex-shrink-0">
                            <span class="text-teal-700 font-semibold text-sm">{{ strtoupper(substr($librarian->name, 0, 2)) }}</span>
                        </div>
                        <span class="font-medium text-gray-800">{{ $librarian->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $librarian->email }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $librarian->department ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $librarian->phone ?? '—' }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $librarian->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $librarian->active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.librarians.edit', $librarian->id) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                    <form action="{{ route('admin.librarians.destroy', $librarian->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Delete {{ $librarian->name }}? This will also delete their transactions.')"
                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-user-slash text-4xl mb-3"></i>
                    <p class="text-lg">No librarians found</p>
                    <a href="{{ route('admin.librarians.create') }}" class="text-teal-600 hover:underline mt-2 inline-block">Add your first librarian</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($librarians->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $librarians->links() }}
    </div>
    @endif
</div>

@endsection
