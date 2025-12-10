<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class CompanyController
{

    public $industries = [
        'Technology',
        'Healthcare',
        'Finance',
        'Education',
        'Retail',
        'Manufacturing',
        'Other'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = Company::latest();
        // Archived
        if ($request->input('archived') == true) {
            $query->onlyTrashed();
        }
        $Companies = $query->paginate(4)->onEachSide(1);
        return view('company.index', compact('Companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();
        //create owner user
        $user = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' => Hash::make($validated['owner_password']),
            'role' => 'company-owner',
        ]);
        //rerurn error if user not created
        if (!$user) {
            return redirect()->route('company.create')->with('error', 'Failed to create company owner user.');
        }
        //create company
        Company::create([
            'name' => $validated['name'],
            'industry' => $validated['industry'],
            'address' => $validated['address'],
            'website' => $validated['website'] ?? null,
            'owner_id' => $user->id,
        ]);

        return redirect()->route('company.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        if ($id === null) {
            $id = auth()->user()->company->id;
        }
        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        if ($id === null) {
            $id = auth()->user()->company->id;
        }
        $company = Company::findOrFail($id);
        $industries = $this->industries;
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id = null)
    {
        if ($id === null) {
            $id = auth()->user()->company->id;
            $redirect = 'my-company.show';
        }
        else{
            $redirect = 'company.show';
        }
        $validated = $request->validated();
        $company = Company::findOrFail($id);
        $company->update([
            'name' => $validated['name'],
            'industry' => $validated['industry'],
            'address' => $validated['address'],
            'website' => $validated['website'] ?? null,
        ]);
        //update owner info
        $ownerdata = [];
        $ownerdata['name'] = $validated['owner_name'];
        if ($validated['owner_password']) {
            $ownerdata['password'] = Hash::make($validated['owner_password']);
        }
        $company->owner->update($ownerdata);

        if ($request->input('redirecttolist') == 'true') {
            return redirect()->route('company.index')->with('success', 'Company updated successfully.');
        }
        return redirect()->route($redirect, $company->id)->with('success', 'Company updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company archived successfully.');
    }
    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('company.index', ['archived' => true])->with('success', 'Company restored successfully.');
    }
}
