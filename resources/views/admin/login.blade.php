<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Admin — Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-800 to-teal-900 flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-white rounded-full w-20 h-20 shadow-lg mb-4">
                <i class="fas fa-book-open text-teal-700 text-3xl"></i>
            </div>
            <h1 class="text-white text-3xl font-bold">Library Admin</h1>
            <p class="text-teal-300 mt-1">Reference Management System</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-gray-800 text-xl font-semibold mb-6">Sign In to Your Account</h2>

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="admin@library.com" required autofocus>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit"
                        class="w-full bg-gradient-to-r from-teal-600 to-teal-700 text-white py-3 rounded-lg font-semibold hover:from-teal-700 hover:to-teal-800 transition-all duration-200 shadow-md">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>
        </div>

        <!-- Test Credentials -->
        <div class="mt-6 bg-teal-700 bg-opacity-50 rounded-xl p-5">
            <p class="text-teal-200 text-sm font-semibold mb-3"><i class="fas fa-key mr-2"></i>Test Credentials</p>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between text-teal-100">
                    <span>admin@library.com</span>
                    <span class="font-mono bg-teal-900 px-2 py-0.5 rounded">admin123</span>
                </div>
                <div class="flex justify-between text-teal-100">
                    <span>manager@library.com</span>
                    <span class="font-mono bg-teal-900 px-2 py-0.5 rounded">manager123</span>
                </div>
                <div class="flex justify-between text-teal-100">
                    <span>staff@library.com</span>
                    <span class="font-mono bg-teal-900 px-2 py-0.5 rounded">staff123</span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
