@php
    if (auth()->user()->role == 'company-owner') {
        $company_name = auth()->user()->company->name;
    } else {
        $company_name = 'companies';
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($company_name) }}{{ $request()->input('archived') == true ? ' - Archived' : '' }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
        @if (auth()->user()->role == 'admin')
            <!--back button-->
            <div class="mb-4">
                <a href="{{ route('company.index')}}"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300">← Back</a>
            </div>
        @endif

        <!--wrapper-->
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow">
            <!-- Company Details -->
            <div>
                <h3 class="text-lg font-bold">Company Information</h3>
                <p><strong>Owner:</strong> {{ $company->owner->name }}</p>
                <p><strong>Owner Email:</strong> {{ $company->owner->email }}</p>
                <p><strong>Name:</strong> {{ $company->name }}</p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                <p><strong>Website:</strong> <a href="{{ $company->website }}" target="_blank"
                        class="text-blue-500 underline hover:text-blue-700">{{ $company->website }}</a></p>
            </div>
            <!--edit and archive buttons-->
            <div class="flex justify-end space-x-4 mb-6">
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('company.edit', ['company' => $company->id]) }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit
                        Company</a>
                    <form action="{{ route('company.destroy', ['company' => $company->id]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Archive
                            Company</button>
                    </form>
                @else
                    <a href="{{ route('my-company.edit') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit
                        Company</a>
                @endif
            </div>
            @if(auth()->user()->role == 'admin')
                <!--tabs navigation-->
                <div class="mb-6">
                    <ul class="flex space-x-4">
                        <li>
                            <a class="px-4 py-2 text-gray-800 font-semibold {{ $request()->input('tab') == 'jobs' || $request()->input('tab') == '' ? 'border-b-2 border-blue-600' : '' }}"
                                href="{{ route('company.show', ['company' => $company->id, 'tab' => 'jobs']) }}">Jobs</a>
                        </li>
                        <li>
                            <a class="px-4 py-2 text-gray-800 font-semibold {{ $request()->input('tab') == 'applications' ? 'border-b-2 border-blue-600' : '' }}"
                                href="{{ route('company.show', ['company' => $company->id, 'tab' => 'applications']) }}">Applications</a>
                        </li>
                    </ul>
                </div>

                <!--tab contents-->
                <div>
                    <!--jobs tab-->
                    <div id="jobs"
                        class="{{ $request()->input('tab') == 'jobs' || $request()->input('tab') == '' ? 'block' : 'hidden' }}">
                        <table class="min-w-full bg-gray-50 rounded-lg shadow">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 bg-gray-100 rounded-tr-lg">Title</th>
                                    <th class="px-4 py-2 bg-gray-100">Type</th>
                                    <th class="px-4 py-2 bg-gray-100">Location</th>
                                    <th class="px-4 py-2 bg-gray-100 rounded-tr-lg">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company->jobvacancies as $job)
                                    <tr>
                                        <td class="px-4 py-2 border-b text-center">{{ $job->title }}</td>
                                        <td class="px-4 py-2 border-b text-center">{{ $job->type }}</td>
                                        <td class="px-4 py-2 border-b text-center">{{ $job->location }}</td>
                                        <td class="px-4 py-2 border-b text-center">
                                            <a href="{{ route('job-vacancies.show', $job->id) }}"
                                                class="text-blue-500 underline hover:text-blue-700">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--applications tab-->
                    <div id="applications" class="{{ $request()->input('tab') == 'applications' ? 'block' : 'hidden' }}">
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
                                @foreach ($company->jobapplications as $application)
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
            @endif
        </div>
    </div>
</x-app-layout>