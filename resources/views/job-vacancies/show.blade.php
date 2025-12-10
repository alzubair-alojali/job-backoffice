<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('job vacancies') }}{{ request()->input('archived') == true ? ' - Archived' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
        <!--back button-->
        <div class="mb-4">
            <a href="{{ route('job-vacancies.index')}}"
                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">← Back</a>
        </div>
        <!--wrapper-->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Job Vacancy Details -->
            <div>
                <h3 class="text-lg font-bold">Job Vacancy Information</h3>
                <p><strong>owner:</strong> {{ $jobVacancy->company->name }}</p>
                <p><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>Salary:</strong> {{ number_format($jobVacancy->salary, 2)}}</p>
                <p><strong>Description:</strong> {{ $jobVacancy->description }}</p>
            </div>
            <!--edit and archive buttons-->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-vacancies.edit', $jobVacancy->id) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit
                    Job Vacancy</a>
                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Archive
                        Job Vacancy</button>
                </form>
            </div>

            <!--tabs navigation-->
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a class="px-4 py-2 text-gray-800 font-semibold border-b-2 border-blue-600"
                            href="{{ route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}">Applications</a>
                    </li>
                </ul>
            </div>

            <!--tab contents-->
            <div>
                <!--applications tab-->
                <div id="applications">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 rounded-tr-lg">Applicant Name</th>
                                <th class="px-4 py-2 bg-gray-100">Job Title</th>
                                <th class="px-4 py-2 bg-gray-100">Status</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tr-lg">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobVacancy->jobApplications as $application)
                                <tr>
                                    <td class="px-4 py-2 border-b text-center">{{ $application->user->name }}</td>
                                    <td class="px-4 py-2 border-b text-center">{{ $application->jobVacancy->title }}</td>
                                    <td class="px-4 py-2 border-b text-center">{{ $application->status }}</td>
                                    <td class="px-4 py-2 border-b text-center">
                                        <a href="{{ route('job-application.show', $application->id) }}"
                                            class="text-blue-500 underline hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>