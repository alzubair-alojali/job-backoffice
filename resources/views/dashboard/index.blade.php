<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <div class="py-12 px-6 flex flex-col gap-4">
        <!--overview cards-->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Card 1: active Users -->
            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">active Users</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['activeuser'] }}</p>
                <p class="text-sm text-gray-500">Last 30 days</p>
            </div>

            <!-- Card 2: Active Jobs -->
            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totaljobs'] }}</p>
                <p class="text-sm text-gray-500">All Time</p>
            </div>

            <!-- Card 3: Applications -->
            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalapplications'] }}</p>
                <p class="text-sm text-gray-500">All Time</p>
            </div>
        </div>

        <!-- most applied jobs table -->
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Most Applied Jobs</h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left uppercase text-gray-500">
                            <th class="py-2">Job Title</th>
                            @if(auth()->user()->role == 'admin')
                            <th class="py-2">Company</th>
                            @endif
                            <th class="py-2"> TotalApplications</th>
                        </tr>
                    </thead>
                    <tbody class=" text-left divide-y divide-gray-200">
                        @foreach (  $analytics['mostappliedjobs'] as $job)
                            <tr>
                                <td class="py-4">{{ $job->title }}</td>
                                @if(auth()->user()->role == 'admin')
                                <td class="py-4">{{ $job->company->name }}</td>
                                @endif
                                <td class="py-4">{{ $job->totalCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- top converting job posts table -->
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Top Converting Job Posts</h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left uppercase text-gray-500">
                            <th class="py-2">Job Title</th>
                            <th class="py-2">View</th>
                            <th class="py-2">Applications</th>
                            <th class="py-2">Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody class=" text-left divide-y divide-gray-200">
                        @foreach ($analytics['conversionrate'] as $job)
                            <tr>
                                <td class="py-4">{{ $job->title }}</td>
                                <td class="py-4">{{ $job->view_count }}</td>
                                <td class="py-4">{{ $job->totalCount }}</td>
                                <td class="py-4">{{ $job->conversion_rate }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>