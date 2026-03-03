@extends('layouts.admin')

@section('page-title')
    <h2 class="text-xl font-semibold text-gray-800">Reference Transactions</h2>
@endsection

@section('content')

<div class="flex justify-between items-center mb-6">
    <p class="text-gray-500">Track and manage all reference service interactions.</p>
    <a href="{{ route('admin.transactions.create') }}"
       class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow">
        <i class="fas fa-plus mr-2"></i>Record Transaction
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patron</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Question</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Librarian</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Duration</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($transactions as $tx)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $tx->patron_name }}</td>
                <td class="px-6 py-4 text-gray-600 max-w-xs">
                    <p class="truncate">{{ $tx->question }}</p>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium
                        @if($tx->type === 'research') bg-purple-100 text-purple-700
                        @elseif($tx->type === 'informational') bg-blue-100 text-blue-700
                        @elseif($tx->type === 'directional') bg-gray-100 text-gray-700
                        @elseif($tx->type === 'reader_advisory') bg-green-100 text-green-700
                        @else bg-orange-100 text-orange-700 @endif">
                        {{ ucfirst(str_replace('_', ' ', $tx->type)) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $tx->librarian->name ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $tx->duration ? $tx->duration . ' min' : '—' }}</td>
                <td class="px-6 py-4 text-gray-500 text-sm">{{ $tx->created_at->format('M j, Y') }}</td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.transactions.edit', $tx->id) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                    <form action="{{ route('admin.transactions.destroy', $tx->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Delete this transaction?')"
                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p class="text-lg">No transactions recorded yet</p>
                    <a href="{{ route('admin.transactions.create') }}" class="text-teal-600 hover:underline mt-2 inline-block">Record your first transaction</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($transactions->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

@endsection
