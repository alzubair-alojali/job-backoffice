<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = User::latest();
        // Archived
        if ($request->input('archived') == true) {
            $query->onlyTrashed();
        }
        $users = $query->paginate(4)->onEachSide(1);
        return view('users.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $user = user::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = user::findOrFail($id);
        $validated = $request->validated();
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = user::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User archived successfully.');
    }
    public function restore(string $id)
    {
        $user = user::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('users.index', ['archived' => true])->with('success', 'User restored successfully.');
    }
}
