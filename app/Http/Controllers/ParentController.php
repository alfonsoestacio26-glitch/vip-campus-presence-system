<?php

namespace App\Http\Controllers;

use App\Models\ParentProfile;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    /**
     * Display all parents.
     */
 public function index(Request $request)
{
    $search = $request->input('search');

    $parents = ParentProfile::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->get();

    return view('parents.index', compact('parents', 'search'));
}

    public function create()
    {
        return view('parents.create');
    }

    /**
     * Store new parent.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);

        ParentProfile::create($validated);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Parent added successfully.');
    }

    /**
     * Show parent profile.
     */
    public function show(ParentProfile $parent)
    {
        return view('parents.show', compact('parent'));
    }

    /**
     * Show Edit Parent form.
     */
    public function edit(ParentProfile $parent)
    {
        return view('parents.edit', compact('parent'));
    }

    /**
     * Update parent.
     */
    public function update(Request $request, ParentProfile $parent)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ]);

        $parent->update($validated);

        return redirect()
            ->route('parents.index')
            ->with('success', 'Parent updated successfully.');
    }

    /**
     * Delete parent.
     */
    public function destroy(ParentProfile $parent)
    {
        $parent->delete();

        return redirect()
            ->route('parents.index')
            ->with('success', 'Parent deleted successfully.');
    }
}