<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('add job Categories') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <form action="{{ route('job-categories.store') }}" method="POST"
            class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Category Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full px-3 py-2 rounded-lg focus:outline-none border {{ $errors->has('name') ? 'border-red-500 focus:ring-2 focus:ring-blue-500' : 'border-gray-300 focus:ring-2 focus:ring-blue-500' }}"
                    required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('job-categories.index') }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Create
                    Category</button>
            </div>
        </form>
    </div>

</x-app-layout>