<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso — Sistema Biblioteca</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-teal-800 to-teal-950 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-4">
            <i class="fas fa-book-open text-white text-2xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-white">Sistema Biblioteca</h1>
        <p class="text-teal-300 text-sm mt-1">Gestione Servizi di Riferimento</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Accedi al pannello</h2>

        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/login" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                    <input type="password" name="password" required
                           class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-sm">
                </div>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2.5 rounded-lg transition-colors duration-200 text-sm mt-2">
                <i class="fas fa-sign-in-alt mr-2"></i>Accedi
            </button>
        </form>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Credenziali di accesso</p>
            <div class="space-y-1 text-xs text-gray-600">
                <div class="flex justify-between"><span>admin@biblioteca.edu</span><code class="bg-gray-200 px-1.5 py-0.5 rounded">admin123</code></div>
                <div class="flex justify-between"><span>manager@biblioteca.edu</span><code class="bg-gray-200 px-1.5 py-0.5 rounded">manager123</code></div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
