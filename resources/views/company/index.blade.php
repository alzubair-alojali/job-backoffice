<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}{{ $request()->input('archived') == true ? ' - Archived' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <!--- messages-->
        <x-toast-notification />
        <div class="flex justify-end space-x-4">
            @if($request()->input('archived') == true)
                <!--active-->
                <a href="{{ route('company.index') }}"
                    class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500">View
                    Active</a>
            @else
                <!--Archived-->
                <a href="{{ route('company.index', ['archived' => true]) }}"
                    class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500">View
                    Archived</a>
            @endif
            <!--add company button-->
            <a href="{{ route('company.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">+
                Add Company</a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Address</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Industry</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">website</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($Companies as $company)
                    <tr class="border-6">
                        <td class="px-6 py-4 text-gray-800">
                            @if($request()->input('archived') == true)
                                <span class="px-6 py-4 text-gray-800">{{ $company->name }}</span>
                            @else
                                <a class="text-blue-500 underline hover:text-blue-700"
                                    href="{{ route('company.show', $company->id) }}">{{ $company->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->address }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->industry }}</td>
                        <td class="px-6 py-4 text-gray-800 hover:text-blue-600"><a href="{{ $company->website }}"
                                target="_blank">{{ $company->website }}</a></td>
                        <td>
                            <div class="flex space-x-4">
                                @if($request()->input('archived') == true)
                                    <!-- Restore button -->
                                    <form action="{{ route('company.restore', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900">♻️ Restore</button>
                                    </form>
                                @else
                                    <!-- Edit button -->
                                    <a href="{{ route('company.edit', [$company->id, 'redirecttolist' => 'true']) }}"
                                        class="text-blue-600 hover:text-blue-900">✍🏻 Edit</a>
                                    <!-- Delete button -->
                                    <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-4">🗃️ Archive</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-600">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $Companies->links() }}
        </div>
    </div>
</x-app-layout>