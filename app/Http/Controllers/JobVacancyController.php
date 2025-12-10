<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public $types = ['Full-time', 'Contract', 'Remote', 'Hybrid'];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobVacancy::latest();

        //job vacancies for company owner
        if (auth()->user()->role == 'company-owner') {
            $query->where('company_id', auth()->user()->company->id);
        }

        // Archived
        if ($request->input('archived') == true) {
            $query->onlyTrashed();
        }

        $JobVacancies = $query->paginate(4)->onEachSide(1);
        return view('job-vacancies.index', compact('JobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = $this->types;
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('job-vacancies.create', compact('types', 'companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create($validated);
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job-vacancies.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobVacancy $jobVacancy)
    {
        $types = $this->types;
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('job-vacancies.edit', compact('jobVacancy', 'types', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validated);
        if ($request->input('redirecttolist') == 'true') {
            return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy updated successfully.');
        }
        return redirect()->route('job-vacancies.show', $jobVacancy->id)->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy deleted successfully.');
    }
    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();
        return redirect()->route('job-vacancies.index',['archived' => 'true'])->with('success', 'Job vacancy restored successfully.');
    }
}
