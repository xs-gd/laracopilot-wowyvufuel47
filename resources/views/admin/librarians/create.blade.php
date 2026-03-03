@extends('layouts.admin')

@section('page-title')
    <h2 class="text-xl font-semibold text-gray-800">Add New Librarian</h2>
@endsection

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow p-8">
        <form action="{{ route('admin.librarians.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('name') border-red-400 @enderror"
                           placeholder="Margaret Collins" required>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('email') border-red-400 @enderror"
                           placeholder="name@library.org" required>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="555-0101">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    <input type="text" name="department" value="{{ old('department') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Reference Services">
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                        <span class="text-sm font-medium text-gray-700">Active Staff Member</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center space-x-3 pt-4 border-t">
                <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow">
                    <i class="fas fa-save mr-2"></i>Save Librarian
                </button>
                <a href="{{ route('admin.librarians.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-all duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
