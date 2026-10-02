<?php

namespace App\Http\Controllers;

use App\Models\ParentProfile;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    /**
     * Display all parents for admin with search, section filter, and pagination.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $section = $request->input('section');

        // Dynamic sections list from linked student records
        $sections = Student::distinct()->whereNotNull('section')->where('section', '!=', '')->pluck('section')->sort()->values();

        $query = ParentProfile::query()->with(['students', 'user']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uQ) use ($search) {
                        $uQ->where('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($section) {
            $query->whereHas('students', function ($sQ) use ($section) {
                $sQ->where('section', $section);
            });
        }

        $parents = $query->latest()->paginate(15)->withQueryString();

        return view('parents.index', compact(
            'parents',
            'search',
            'section',
            'sections'
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
        $parent->load(['students', 'user']);

        $linkedStudentIds = $parent->students
            ->pluck('id')
            ->toArray();

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

        if (
            $parent->students()
                ->where('student_id', $validated['student_id'])
                ->exists()
        ) {
            return redirect()
                ->route('parents.show', $parent)
                ->with('error', 'This student is already linked to this parent.');
        }

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
        $parent->load('user');

        return view('parents.edit', compact('parent'));
    }

    /**
     * Update parent and manage parent login account.
     */
    public function update(
        Request $request,
        ParentProfile $parent
    ) {
        $parent->load('user');

        $rules = [
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email' . ($parent->user_id ? ',' . $parent->user_id : ''),
            ],

            'password' => 'nullable|string|min:8|confirmed',
        ];

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $parent) {

            /*
            |--------------------------------------------------------------------------
            | Update Parent Profile
            |--------------------------------------------------------------------------
            */

            $parent->update([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Prepare Parent Account Name
            |--------------------------------------------------------------------------
            */

            $accountName = trim(
                $validated['first_name'] . ' ' .
                ($validated['middle_name'] ?? '') . ' ' .
                $validated['last_name']
            );

            /*
            |--------------------------------------------------------------------------
            | Existing User Account
            |--------------------------------------------------------------------------
            */

            if ($parent->user) {

                $userData = [
                    'name' => $accountName,
                    'email' => $validated['email'],
                    'role' => 'parent',
                ];

                /*
                | Only change password when Admin entered a new one.
                */
                if (!empty($validated['password'])) {
                    $userData['password'] = $validated['password'];
                }

                $parent->user->update($userData);
            }

            /*
            |--------------------------------------------------------------------------
            | No User Account Yet
            |--------------------------------------------------------------------------
            */

            else {

                $user = User::create([
                    'name' => $accountName,
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => 'parent',
                ]);

                /*
                | Link the new User to the existing ParentProfile.
                */
                $parent->update([
                    'user_id' => $user->id,
                ]);
            }
        });

        return redirect()
            ->route('parents.index')
            ->with('success', 'Parent information and account updated successfully.');
    }

    /**
     * Delete parent.
     */
    public function destroy(ParentProfile $parent)
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($parent) {
            $user = $parent->user;
            $parent->students()->detach();
            $parent->delete();
            if ($user) {
                $user->delete();
            }
        });

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

        if (
            $parent->photo &&
            \Illuminate\Support\Facades\Storage::disk('public')->exists($parent->photo)
        ) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($parent->photo);
        }

        $path = $request->file('photo')->store('parents/photos', 'public');

        $parent->update([
            'photo' => $path
        ]);

        return back()->with('success', 'Parent photo updated successfully.');
    }
}