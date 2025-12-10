<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('job vacancies') }}{{ $request()->input('archived') == true ? ' - Archived' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <!--- messages-->
        <x-toast-notification />
        <div class="flex justify-end space-x-4">
            @if($request()->input('archived') == true)
                <!--active-->
                <a href="{{ route('job-vacancies.index') }}"
                    class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500">View
                    Active</a>
            @else
                <!--Archived-->
                <a href="{{ route('job-vacancies.index', ['archived' => true]) }}"
                    class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500">View
                    Archived</a>
            @endif
            <!--add job vacancy button-->
            <a href="{{ route('job-vacancies.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">+
                Add Job Vacancy</a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($JobVacancies as $jobvacancy)
                    <tr class="border-6">
                        <td class="px-6 py-4 text-gray-800">
                            @if($request()->input('archived') == true)
                                <span class="px-6 py-4 text-gray-800">{{ $jobvacancy->title }}</span>
                            @else
                                <a class="text-blue-500 underline hover:text-blue-700"
                                    href="{{ route('job-vacancies.show', $jobvacancy->id) }}">{{ $jobvacancy->title }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobvacancy->company->name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobvacancy->location }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobvacancy->type }}</td>
                        <td class="px-6 py-4 text-gray-800">${{ number_format($jobvacancy->salary, 2) }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if($request()->input('archived') == true)
                                    <!-- Restore button -->
                                    <form action="{{ route('job-vacancies.restore', $jobvacancy->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900">♻️ Restore</button>
                                    </form>
                                @else
                                    <!-- Edit button -->
                                    <a href="{{ route('job-vacancies.edit', [$jobvacancy->id, 'redirecttolist' => 'true']) }}"
                                        class="text-blue-600 hover:text-blue-900">✍🏻 Edit</a>
                                    <!-- Delete button -->
                                    <form action="{{ route('job-vacancies.destroy', $jobvacancy->id) }}" method="POST"
                                        class="inline">
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
                        <td colspan="6  " class="px-6 py-4 text-center text-gray-600">No job vacancies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $JobVacancies->links() }}
        </div>
    </div>
</x-app-layout>