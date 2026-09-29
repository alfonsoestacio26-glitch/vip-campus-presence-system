<?php

namespace App\Http\Controllers;

use App\Models\ParentProfile;
use App\Models\Student;
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
            ->with('students')
            ->latest()
            ->get();

        return view('parents.index', compact(
            'parents',
            'search'
        ));
    }

    /**
     * Show create parent form.
     */
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
        /*
        |--------------------------------------------------------------------------
        | Load students already linked to this parent
        |--------------------------------------------------------------------------
        */
        $parent->load('students');

        /*
        |--------------------------------------------------------------------------
        | Get IDs of already linked students
        |--------------------------------------------------------------------------
        */
        $linkedStudentIds = $parent->students
            ->pluck('id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Get students that are NOT yet linked
        |--------------------------------------------------------------------------
        */
        $students = Student::query()
            ->when(count($linkedStudentIds) > 0, function ($query) use ($linkedStudentIds) {
                $query->whereNotIn('id', $linkedStudentIds);
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('parents.show', compact(
            'parent',
            'students'
        ));
    }

    /**
     * Link a student to a parent.
     */
    public function attachStudent(
        Request $request,
        ParentProfile $parent
    ) {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'relationship' => 'required|string|max:50',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate relationship
        |--------------------------------------------------------------------------
        */
        if (
            $parent->students()
                ->where('student_id', $validated['student_id'])
                ->exists()
        ) {
            return redirect()
                ->route('parents.show', $parent)
                ->with('error', 'This student is already linked to this parent.');
        }

        /*
        |--------------------------------------------------------------------------
        | Attach student
        |--------------------------------------------------------------------------
        */
        $parent->students()->attach(
            $validated['student_id'],
            [
                'relationship' => $validated['relationship'],
            ]
        );

        return redirect()
            ->route('parents.show', $parent)
            ->with('success', 'Student linked successfully.');
    }

    /**
     * Remove a student from a parent.
     */
    public function detachStudent(
        ParentProfile $parent,
        Student $student
    ) {
        $parent->students()->detach($student->id);

        return redirect()
            ->route('parents.show', $parent)
            ->with('success', 'Student unlinked successfully.');
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
    public function update(
        Request $request,
        ParentProfile $parent
    ) {
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

    /**
     * Upload or update parent photo directly.
     */
    public function updatePhoto(Request $request, ParentProfile $parent)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($parent->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($parent->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($parent->photo);
        }

        $path = $request->file('photo')->store('parents/photos', 'public');
        $parent->update(['photo' => $path]);

        return back()->with('success', 'Parent photo updated successfully.');
    }
}