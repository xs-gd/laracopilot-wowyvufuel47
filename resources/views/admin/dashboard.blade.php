@extends('layouts.admin')

@section('page-title')
    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
@endsection

@section('content')

<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-teal-600 to-teal-800 rounded-2xl p-6 mb-8 text-white shadow-lg">
    <h3 class="text-2xl font-bold">Welcome back, {{ session('admin_user', 'Admin') }}! 👋</h3>
    <p class="text-teal-200 mt-1">Here's an overview of the library reference system.</p>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-teal-100 rounded-full p-4">
            <i class="fas fa-user-tie text-teal-600 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Total Librarians</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalLibrarians }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-green-100 rounded-full p-4">
            <i class="fas fa-check-circle text-green-600 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Active Librarians</p>
            <p class="text-3xl font-bold text-gray-800">{{ $activeLibrarians }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-blue-100 rounded-full p-4">
            <i class="fas fa-exchange-alt text-blue-600 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Total Transactions</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalTransactions }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-4">
        <div class="bg-purple-100 rounded-full p-4">
            <i class="fas fa-calendar-day text-purple-600 text-xl"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Today's Transactions</p>
            <p class="text-3xl font-bold text-gray-800">{{ $todayTransactions }}</p>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="font-semibold text-gray-800"><i class="fas fa-clock text-teal-500 mr-2"></i>Recent Transactions</h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-teal-600 text-sm hover:underline">View all</a>
        </div>
        <div class="divide-y">
            @forelse($recentTransactions as $tx)
            <div class="px-6 py-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium text-gray-800">{{ $tx->patron_name }}</p>
                        <p class="text-gray-500 text-sm truncate max-w-xs">{{ $tx->question }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full
                        @if($tx->type === 'research') bg-purple-100 text-purple-700
                        @elseif($tx->type === 'informational') bg-blue-100 text-blue-700
                        @elseif($tx->type === 'directional') bg-gray-100 text-gray-700
                        @elseif($tx->type === 'reader_advisory') bg-green-100 text-green-700
                        @else bg-orange-100 text-orange-700 @endif">
                        {{ ucfirst(str_replace('_', ' ', $tx->type)) }}
                    </span>
                </div>
                <p class="text-teal-600 text-xs mt-1">by {{ $tx->librarian->name ?? 'N/A' }}</p>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400">
                <i class="fas fa-inbox text-2xl mb-2"></i>
                <p>No transactions yet</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Latest Librarians -->
    <div class="bg-white rounded-xl shadow">
        <div class="flex items-center justify-between p-6 border-b">
            <h3 class="font-semibold text-gray-800"><i class="fas fa-users text-teal-500 mr-2"></i>Latest Librarians</h3>
            <a href="{{ route('admin.librarians.index') }}" class="text-teal-600 text-sm hover:underline">View all</a>
        </div>
        <div class="divide-y">
            @forelse($latestLibrarians as $lib)
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-teal-100 rounded-full w-9 h-9 flex items-center justify-center">
                        <span class="text-teal-700 font-semibold text-sm">{{ strtoupper(substr($lib->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $lib->name }}</p>
                        <p class="text-gray-500 text-sm">{{ $lib->department ?? 'No Department' }}</p>
                    </div>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $lib->active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $lib->active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400">
                <i class="fas fa-inbox text-2xl mb-2"></i>
                <p>No librarians yet</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
