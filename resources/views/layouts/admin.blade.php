<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-teal-800 to-teal-900 min-h-screen flex flex-col shadow-xl">
        <div class="p-6 border-b border-teal-700">
            <div class="flex items-center space-x-3">
                <div class="bg-teal-600 rounded-full p-2">
                    <i class="fas fa-book-open text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg leading-tight">Library</h1>
                    <p class="text-teal-300 text-xs">Admin Panel</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-teal-600 text-white' : 'text-teal-200 hover:bg-teal-700 hover:text-white' }}">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.librarians.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.librarians.*') ? 'bg-teal-600 text-white' : 'text-teal-200 hover:bg-teal-700 hover:text-white' }}">
                <i class="fas fa-user-tie w-5"></i>
                <span>Librarians</span>
            </a>
            <a href="{{ route('admin.transactions.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-teal-600 text-white' : 'text-teal-200 hover:bg-teal-700 hover:text-white' }}">
                <i class="fas fa-exchange-alt w-5"></i>
                <span>Transactions</span>
            </a>
        </nav>

        <div class="p-4 border-t border-teal-700">
            <div class="flex items-center space-x-3 mb-3 px-2">
                <div class="bg-teal-600 rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div>
                    <p class="text-white text-sm font-medium">{{ session('admin_user', 'Admin') }}</p>
                    <p class="text-teal-400 text-xs">{{ session('admin_email', '') }}</p>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-teal-200 hover:text-white hover:bg-teal-700 rounded-lg transition-all duration-200">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
            <div>
                @yield('page-title', '<h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>')
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-500 text-sm">{{ date('l, F j, Y') }}</span>
            </div>
        </header>

        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

</body>
</html>
