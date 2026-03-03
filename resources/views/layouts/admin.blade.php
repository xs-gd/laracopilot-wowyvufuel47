<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Biblioteca') — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-teal-800 to-teal-900 text-white flex flex-col flex-shrink-0">
        <div class="px-6 py-5 border-b border-teal-700">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-teal-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book-open text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-bold text-sm leading-tight">Biblioteca</p>
                    <p class="text-teal-300 text-xs">Sistema di Riferimento</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : 'text-teal-200 hover:bg-teal-700 hover:text-white' }}">
                <i class="fas fa-tachometer-alt w-5 text-center"></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.librarians.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.librarians.*') ? 'bg-teal-600 text-white' : 'text-teal-200 hover:bg-teal-700 hover:text-white' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="text-sm font-medium">Bibliotecari</span>
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-teal-600 text-white' : 'text-teal-200 hover:bg-teal-700 hover:text-white' }}">
                <i class="fas fa-exchange-alt w-5 text-center"></i>
                <span class="text-sm font-medium">Transazioni</span>
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-teal-700">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center text-xs font-bold">
                    {{ strtoupper(substr(session('admin_user', 'A'), 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-white">{{ ucfirst(session('admin_user', 'Admin')) }}</p>
                    <p class="text-xs text-teal-300">{{ session('admin_email', '') }}</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-2 px-3 py-2 text-teal-200 hover:text-white hover:bg-teal-700 rounded-lg text-sm transition-all">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Esci</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->locale('it')->isoFormat('dddd D MMMM YYYY') }}</span>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
