@extends('layouts.admin')

@section('page-title')
    <h2 class="text-xl font-semibold text-gray-800">Record New Transaction</h2>
@endsection

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow p-8">
        <form action="{{ route('admin.transactions.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Patron Name <span class="text-red-500">*</span></label>
                    <input type="text" name="patron_name" value="{{ old('patron_name') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('patron_name') border-red-400 @enderror"
                           placeholder="John Smith" required>
                    @error('patron_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Librarian <span class="text-red-500">*</span></label>
                    <select name="librarian_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('librarian_id') border-red-400 @enderror"
                            required>
                        <option value="">Select librarian...</option>
                        @foreach($librarians as $lib)
                            <option value="{{ $lib->id }}" {{ old('librarian_id') == $lib->id ? 'selected' : '' }}>{{ $lib->name }}</option>
                        @endforeach
                    </select>
                    @error('librarian_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Type <span class="text-red-500">*</span></label>
                    <select name="type"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('type') border-red-400 @enderror"
                            required>
                        <option value="">Select type...</option>
                        <option value="directional"    {{ old('type') === 'directional'    ? 'selected' : '' }}>Directional</option>
                        <option value="informational" {{ old('type') === 'informational' ? 'selected' : '' }}>Informational</option>
                        <option value="research"       {{ old('type') === 'research'       ? 'selected' : '' }}>Research</option>
                        <option value="reader_advisory"{{ old('type') === 'reader_advisory'? 'selected' : '' }}>Reader Advisory</option>
                        <option value="technology"     {{ old('type') === 'technology'     ? 'selected' : '' }}>Technology</option>
                    </select>
                    @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                    <input type="number" name="duration" value="{{ old('duration') }}" min="1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="10">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Question / Request <span class="text-red-500">*</span></label>
                    <textarea name="question" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('question') border-red-400 @enderror"
                              placeholder="Describe the patron's question or request..." required>{{ old('question') }}</textarea>
                    @error('question')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Answer / Response Provided</label>
                    <textarea name="answer" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                              placeholder="What answer or resources were provided to the patron...">{{ old('answer') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                    <textarea name="notes" rows="2"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                              placeholder="Any additional observations or follow-up needed...">{{ old('notes') }}</textarea>
                </div>

            </div>

            <div class="flex items-center space-x-3 pt-4 border-t">
                <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow">
                    <i class="fas fa-save mr-2"></i>Save Transaction
                </button>
                <a href="{{ route('admin.transactions.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-all duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
