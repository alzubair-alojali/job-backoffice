<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('edit job application status') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <form
            action="{{ route('job-application.update', ['job_application' => $jobApplication->id, 'redirecttolist' => $request('redirecttolist')]) }}"
            method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <!--job application details-->
            <div class="mb-4 p-6 bg-gray-50 border rounded-lg shadow-md">
                <h3 class="text-lg font-bold">Job Application Details</h3>

                <!--applicant name-->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Applicant name</label>
                    <span>{{ $jobApplication->user->name }}</span>
                </div>
                <!--job vacancy-->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Job Vacancy</label>
                    <span>{{ $jobApplication->jobVacancy->title }}</span>
                </div>
                <!--company-->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Company</label>
                    <span>{{ $jobApplication->jobVacancy->company->name }}</span>
                </div>
                <!--ai generated score-->
                <div class="mb-4">
                    <label for="aigeneratedScore" class="block text-sm font-medium text-gray-700">AI Generated
                        Score</label>
                    <span>{{ $jobApplication->aigeneratedScore }}</span>
                </div>
                <!--ai generated feedback-->
                <div class="mb-4">
                    <label for="aigeneratedFeedback" class="block text-sm font-medium text-gray-700">AI Generated
                        Feedback</label>
                    <span>{{ $jobApplication->aigeneratedFeedback }}</span>
                </div>
                <!--status-->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($status as $stat)
                            <option value="{{ $stat }}" {{ old('status', $jobApplication->status) == $stat ? 'selected' : '' }}>
                                {{ ucfirst($stat) }}
                            </option>
                        @endforeach

                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('job-application.index') }}"
                    class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Update
                    Job Application status</button>
            </div>
        </form>
    </div>

</x-app-layout>