<?php

namespace App\Http\Controllers;

use App\Models\Guard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuardController extends Controller
{
    /**
     * Display a listing of the guards.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $guards = Guard::query()
            ->with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('employee_no', 'like', "%{$search}%")
                      ->orWhere('contact_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($uQ) use ($search) {
                          $uQ->where('email', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->get();

        return view('guards.index', compact('guards', 'search'));
    }

    /**
     * Show the form for creating a new guard.
     */
    public function create()
    {
        return view('guards.create');
    }

    /**
     * Store a newly created guard in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_no' => 'required|string|max:50|unique:guards,employee_no',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'contact_number' => 'nullable|string|max:30',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:8',
        ]);

        DB::transaction(function () use ($validated) {
            // Create user
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'] ?? 'password'),
                'role' => 'guard',
            ]);

            // Create guard profile
            Guard::create([
                'user_id' => $user->id,
                'employee_no' => $validated['employee_no'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'contact_number' => $validated['contact_number'] ?? null,
            ]);
        });

        return redirect()
            ->route('guards.index')
            ->with('success', 'Guard added successfully.');
    }

    /**
     * Display the specified guard.
     */
    public function show(Guard $guard)
    {
        $guard->load('user');
        return view('guards.show', compact('guard'));
    }

    /**
     * Show the form for editing the specified guard.
     */
    public function edit(Guard $guard)
    {
        $guard->load('user');
        return view('guards.edit', compact('guard'));
    }

    /**
     * Update the specified guard in storage.
     */
    public function update(Request $request, Guard $guard)
    {
        $validated = $request->validate([
            'employee_no' => 'required|string|max:50|unique:guards,employee_no,' . $guard->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'contact_number' => 'nullable|string|max:30',
            'email' => 'required|email|max:255|unique:users,email,' . $guard->user_id,
            'password' => 'nullable|string|min:8',
        ]);

        DB::transaction(function () use ($validated, $guard) {
            // Update User login details
            $userData = [
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $guard->user->update($userData);

            // Update Guard profile
            $guard->update([
                'employee_no' => $validated['employee_no'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'contact_number' => $validated['contact_number'] ?? null,
            ]);
        });

        return redirect()
            ->route('guards.index')
            ->with('success', 'Guard updated successfully.');
    }

    /**
     * Remove the specified guard from storage.
     */
    public function destroy(Guard $guard)
    {
        DB::transaction(function () use ($guard) {
            $user = $guard->user;
            $guard->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()
            ->route('guards.index')
            ->with('success', 'Guard deleted successfully.');
    }
}
