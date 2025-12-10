<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\Resume;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $jobdata = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobapplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        //create job categories
        foreach ($jobdata['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        //create companies
        foreach ($jobdata['companies'] as $company) {
            $companyowner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('123456789'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);
            Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'owner_id' => $companyowner->id,
            ]);
        }
        //create job vacancies
        foreach ($jobdata['jobVacancies'] as $vacancy) {
            $company = Company::where('name', $vacancy['company'])->firstOrFail();
            $category = JobCategory::where('name', $vacancy['category'])->firstOrFail();
            JobVacancy::firstOrCreate([
                'title' => $vacancy['title'],
            ], [
                'description' => $vacancy['description'],
                'location' => $vacancy['location'],
                'type' => $vacancy['type'],
                'salary' => $vacancy['salary'],
                'required_skills' => fake()->words(5, true),
                'view_count' => rand(0, 1000),
                'job_category_id' => $category->id,
                'company_id' => $company->id,
            ]);
        }
        //create job applications
        foreach ($jobapplications['jobApplications'] as $application) {
            // Create candidate user from resume contact details
            $resumeData = $application['resume'];

            // Extract email from contact details string
            preg_match('/Email:\s*([^\s,]+)/', $resumeData['contactDetails'], $emailMatch);
            $email = $emailMatch[1] ?? fake()->unique()->safeEmail();

            // Extract name from contact details or generate one
            preg_match('/Name:\s*([^,]+)/', $resumeData['contactDetails'], $nameMatch);
            $name = $nameMatch[1] ?? fake()->name();

            $candidate = User::firstOrCreate([
                'email' => $email,
            ], [
                'name' => $name,
                'password' => Hash::make('123456789'),
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);

            // Create resume - use correct column names from migration
            $resume = Resume::create([
                'file_name' => $resumeData['filename'],           // file_name not filename
                'file_url' => $resumeData['fileUri'],             // file_url not file_uri
                'contact_details' => $resumeData['contactDetails'],
                'summary' => $resumeData['summary'],
                'skills' => $resumeData['skills'],
                'experience' => $resumeData['experience'],
                'education' => $resumeData['education'],
                'user_id' => $candidate->id,
            ]);

            // Get a random job vacancy for this application
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            // Create job application - use camelCase column names from migration
            JobApplication::create([
                'status' => $application['status'],
                'aigeneratedScore' => $application['aiGeneratedScore'],      // camelCase
                'aigeneratedFeedback' => $application['aiGeneratedFeedback'], // camelCase
                'resume_id' => $resume->id,
                'job_vacancy_id' => $jobVacancy->id,
                'user_id' => $candidate->id,
            ]);
        }

    }
}