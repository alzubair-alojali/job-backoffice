<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;

class dashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $analytics = $this->adminDashboard();
        } elseif (auth()->user()->role == 'company-owner') {
            $analytics = $this->companyOwnerDashboard();
        }
        return view('dashboard.index', compact('analytics'));
    }

    private function adminDashboard()
    {
        //active users in last 30 days(job-seeker role)
        $activeuser = User::where('last_login_at', '>=', now()->subDays(30))->where('role', 'job-seeker')->count();

        //total jobs(not deleted)
        $totaljobs = JobVacancy::whereNull('deleted_at')->count();

        //total applications(not deleted)
        $totalapplications = JobApplication::whereNull('deleted_at')->count();

        //most applied jobs (top 5)
        $mostappliedjobs = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get();

        //conversion rate
        $conversionrate = JobVacancy::withCount('jobApplications as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->view_count > 0) {
                    $job->conversion_rate = round(($job->totalCount / $job->view_count) * 100, 2);
                } else {
                    $job->conversion_rate = 0;
                }
                return $job;
            });
        $analytics = [
            'activeuser' => $activeuser,
            'totaljobs' => $totaljobs,
            'totalapplications' => $totalapplications,
            'mostappliedjobs' => $mostappliedjobs,
            'conversionrate' => $conversionrate,
        ];
        return $analytics;
    }

    private function companyOwnerDashboard()
    {
        //active users in last 30 days(job-seeker role)
        $activeuser = User::where('last_login_at', '>=', now()->subDays(30))->where('role', 'job-seeker')->count();

        //total jobs(not deleted)
        $totaljobs = JobVacancy::whereNull('deleted_at')->where('company_id', auth()->user()->company->id)->count();

        //total applications(not deleted)
        $totalapplications = JobApplication::whereNull('deleted_at')
            ->wherehas('jobVacancy', function ($jobVacancy) {
                $jobVacancy->where('company_id', auth()->user()->company->id);
            })->count();

        //most applied jobs (top 5)
        $mostappliedjobs = JobVacancy::withCount('jobApplications as totalCount')
            ->whereNull('deleted_at')
            ->where('company_id', auth()->user()->company->id)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get();
        //conversion rate
        $conversionrate = JobVacancy::withCount('jobApplications as totalCount')
            ->having('totalCount', '>', 0)
            ->where('company_id', auth()->user()->company->id)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->view_count > 0) {
                    $job->conversion_rate = round(($job->totalCount / $job->view_count) * 100, 2);
                } else {
                    $job->conversion_rate = 0;
                }
                return $job;
            });
        $analytics = [
            'activeuser' => $activeuser,
            'totaljobs' => $totaljobs,
            'totalapplications' => $totalapplications,
            'mostappliedjobs' => $mostappliedjobs,
            'conversionrate' => $conversionrate,
        ];
        return $analytics;
    }
}
