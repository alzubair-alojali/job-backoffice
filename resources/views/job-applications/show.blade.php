<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($jobApplication->user->name . ' | applied to ' . $jobApplication->jobVacancy->title) }}{{ request()->input('archived') == true ? ' - Archived' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
        <!--back button-->
        <div class="mb-4">
            <a href="{{ route('job-application.index')}}"
                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">← Back</a>
        </div>
        <!--wrapper-->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Job Vacancy Details -->
            <div>
                <h3 class="text-lg font-bold">Application Details</h3>
                <p><strong>applicant: </strong> {{ $jobApplication->user->name }}</p>
                <p><strong>Job vacancy: </strong> {{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Company: </strong> {{ $jobApplication->jobVacancy->company->name }}</p>
                <p><strong>Status: </strong><span
                        class="@if ($jobApplication->status == 'accepted') text-green-600 @elseif ($jobApplication->status == 'rejected') text-red-600 @else text-yellow-500 @endif">{{ $jobApplication->status }}</span>
                </p>
                <p><strong>Resume: </strong> <a class="text-blue-500 hover:text-blue-700 underline " target="_blank"
                        href="{{ $jobApplication->resume->file_url }}">{{ $jobApplication->resume->file_url }}</a></p>
            </div>
            <!--edit and archive buttons-->
            <div class="flex justify-end space-x-4 mb-6">
                <a href="{{ route('job-application.edit', $jobApplication->id) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit
                    Job Application</a>
                <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Archive
                        Job Application</button>
                </form>
            </div>

            <!--tabs navigation-->
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a class="px-4 py-2 text-gray-800 font-semibold {{ request()->input('tab') == 'resume' || request()->input('tab') == '' ? 'border-b-2 border-blue-600' : '' }}"
                            href="{{ route('job-application.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}">Resume</a>
                    </li>
                    <li>
                        <a class="px-4 py-2 text-gray-800 font-semibold {{ request()->input('tab') == 'aifeedback' ? 'border-b-2 border-blue-600' : '' }}"
                            href="{{ route('job-application.show', ['job_application' => $jobApplication->id, 'tab' => 'aifeedback']) }}">AI
                            Feedback</a>
                    </li>
                </ul>
            </div>

            <!--tab contents-->
            <div>
                <!--resume tab-->
                <div id="resume"
                    class="{{ request()->input('tab') == 'resume' || request()->input('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 rounded-tr-lg">Summary</th>
                                <th class="px-4 py-2 bg-gray-100">Skills</th>
                                <th class="px-4 py-2 bg-gray-100">Experience</th>
                                <th class="px-4 py-2 bg-gray-100 rounded-tr-lg">Education</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 border-b text-center">{{ $jobApplication->resume->summary }}</td>
                                <td class="px-4 py-2 border-b text-center">{{ $jobApplication->resume->skills }}</td>
                                <td class="px-4 py-2 border-b text-center">{{ $jobApplication->resume->experience }}
                                </td>
                                <td class="px-4 py-2 border-b text-center">{{ $jobApplication->resume->education }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--ai feedback tab-->
                <div id="aifeedback" class="{{ request()->input('tab') == 'aifeedback' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 rounded-tr-lg">AI score</th>
                                <th class="px-4 py-2 bg-gray-100">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 border-b text-center">{{ $jobApplication->aigeneratedScore }}</td>
                                <td class="px-4 py-2 border-b text-center">{{ $jobApplication->aigeneratedFeedback }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>