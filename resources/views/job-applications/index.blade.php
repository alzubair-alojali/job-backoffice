<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('job applications') }}{{ request()->input('archived') == true ? ' - Archived' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <!--- messages-->
        <x-toast-notification />
        <div class="flex justify-end space-x-4">
            @if(request()->input('archived') == true)
                <!--active-->
                <a href="{{ route('job-application.index') }}"
                    class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500">View
                    Active</a>
            @else
                <!--Archived-->
                <a href="{{ route('job-application.index', ['archived' => true]) }}"
                    class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500">View
                    Archived</a>
            @endif

        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applications Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">position (Job vacancy)</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($JobApplications as $jobApplication)
                    <tr class="border-6">
                        <td class="px-6 py-4 text-gray-800">
                            @if(request()->input('archived') == true)
                                <span class="px-6 py-4 text-gray-800">{{ $jobApplication->user->name }}</span>
                            @else
                                <a class="text-blue-500 underline hover:text-blue-700"
                                    href="{{ route('job-application.show', $jobApplication->id) }}">{{ $jobApplication->user->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy->title }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy->company->name }}</td>
                        <td
                            class="px-6 py-4 @if ($jobApplication->status == 'accepted') text-green-600 @elseif ($jobApplication->status == 'rejected') text-red-600 @else text-yellow-500 @endif">
                            {{ $jobApplication->status }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if(request()->input('archived') == true)
                                    <!-- Restore button -->
                                    <form action="{{ route('job-application.restore', $jobApplication->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900">♻️ Restore</button>
                                    </form>
                                @else
                                    <!-- Edit button -->
                                    <a href="{{ route('job-application.edit', [$jobApplication->id, 'redirecttolist' => 'true']) }}"
                                        class="text-blue-600 hover:text-blue-900">✍🏻 Edit</a>
                                    <!-- Delete button -->
                                    <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST"
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
                        <td colspan="6  " class="px-6 py-4 text-center text-gray-600">No job applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $JobApplications->links() }}
        </div>
    </div>
</x-app-layout>