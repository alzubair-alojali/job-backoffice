<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('edit job vacancy') }}
        </h2>
    </x-slot>
    <div class="overflow-x-auto p-6">
        <form
            action="{{ route('job-vacancies.update', ['job_vacancy' => $jobVacancy->id, 'redirecttolist' => $request('redirecttolist')]) }}"
            method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')

            <!--job vacancy details-->
            <div class="mb-4 p-6 bg-gray-50 border rounded-lg shadow-md">
                <h3 class="text-lg font-bold">Job Vacancy Details</h3>
                <p class="text-sm mb-4">enter the job vacancy details</p>

                <!--tiitle-->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $jobVacancy->title) }}"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none border {{ $errors->has('title') ? 'border-red-500 focus:ring-2 focus:ring-blue-500' : 'border-gray-300 focus:ring-2 focus:ring-blue-500' }}"
                        required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!--location-->
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location"
                        value="{{ old('location', $jobVacancy->location) }}"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none border {{ $errors->has('location') ? 'border-red-500 focus:ring-2 focus:ring-blue-500' : 'border-gray-300 focus:ring-2 focus:ring-blue-500' }}"
                        required>
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!--salary-->
                <div class="mb-4">
                    <label for="salary" class="block text-sm font-medium text-gray-700">expected Salary (USD)</label>
                    <input type="number" name="salary" id="salary" value="{{ old('salary', $jobVacancy->salary) }}"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none border {{ $errors->has('salary') ? 'border-red-500 focus:ring-2 focus:ring-blue-500' : 'border-gray-300 focus:ring-2 focus:ring-blue-500' }}"
                        required>
                    @error('salary')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!--required skills-->
                <div class="mb-4">
                    <label for="required_skills" class="block text-sm font-medium text-gray-700">Required Skill</label>
                    <input type="text" name="required_skills" id="required_skills"
                        value="{{ old('required_skills', $jobVacancy->required_skills) }}"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none border {{ $errors->has('required_skills') ? 'border-red-500 focus:ring-2 focus:ring-blue-500' : 'border-gray-300 focus:ring-2 focus:ring-blue-500' }}"
                        required>
                    @error('required_skills')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!--type-->
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($types as $type)
                            <option value="{{ $type }}" {{ old('type', $jobVacancy->type) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach

                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!--company-->
                <div class="mb-4">
                    <label for="company_id" class="block text-sm font-medium text-gray-700">Company</label>
                    <select name="company_id"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $jobVacancy->company_id) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!--job category-->
                <div class="mb-4">
                    <label for="job_category_id" class="block text-sm font-medium text-gray-700">Job Category</label>
                    <select name="job_category_id"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($jobCategories as $category)
                            <option value="{{ $category->id }}" {{ old('job_category_id', $jobVacancy->job_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                    @error('job_category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!--description-->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none border {{ $errors->has('description') ? 'border-red-500 focus:ring-2 focus:ring-blue-500' : 'border-gray-300 focus:ring-2 focus:ring-blue-500' }}"
                        required>{{ old('description', $jobVacancy->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('job-vacancies.index') }}"
                        class="text-gray-600 hover:text-gray-900 px-4 py-2">Cancel</a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit
                        Job Vacancy</button>
                </div>
        </form>
    </div>

</x-app-layout>