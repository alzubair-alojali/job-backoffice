<?php

namespace App\Http\Controllers;

use App\Http\Requests\jobApplicationUpdateRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;


class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobApplication::latest();

        //application for company owner
        if (auth()->user()->role == 'company-owner') {
            $query->whereHas('jobVacancy', function ($jobVacancy) {
                $jobVacancy->where('company_id', auth()->user()->company->id);
            });
        }
        // Archived
        if ($request->input('archived') == true) {
            $query->onlyTrashed();
        }
        $JobApplications = $query->paginate(4)->onEachSide(1);
        return view('job-applications.index', compact('JobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job-applications.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $status = ['pending', 'accepted', 'rejected'];
        return view('job-applications.edit', compact('jobApplication', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(jobApplicationUpdateRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $validated = $request->validated();
        $jobApplication->update([
            'status' => $validated['status']
        ]);
        if ($request->input('redirecttolist') == 'true') {
            return redirect()->route('job-application.index')->with([
                'success' => 'Job application status updated successfully.'
            ]);
        }
        return redirect()->route('job-application.show', $jobApplication->id)->with([
            'success' => 'Job application status updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job-application.index')->with('success', 'Job application archived successfully.');
    }
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route('job-application.index', ['archived' => 'true'])->with('success', 'Job application restored successfully.');
    }
}
