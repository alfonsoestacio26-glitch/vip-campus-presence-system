<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display all students for admin with multi-field filtering and pagination.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $grade = $request->input('grade_level');
        $section = $request->input('section');
        $status = $request->input('status');

        $gradeLevels = Student::distinct()->whereNotNull('grade_level')->where('grade_level', '!=', '')->pluck('grade_level')->sort()->values();
        $sections = Student::distinct()->whereNotNull('section')->where('section', '!=', '')->pluck('section')->sort()->values();
        $statuses = Student::distinct()->whereNotNull('status')->where('status', '!=', '')->pluck('status')->sort()->values();

        $query = Student::with('parents');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('student_no', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($grade) {
            $query->where('grade_level', $grade);
        }

        if ($section) {
            $query->where('section', $section);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        return view('students.index', compact(
            'students',
            'search',
            'grade',
            'section',
            'status',
            'gradeLevels',
            'sections',
            'statuses'
        ));
    }

    /**
     * Display students for teachers restricted to teacher's section.
     */
    public function teacherIndex(Request $request)
    {
        $user = auth()->user();
        $teacher = $user->role === 'teacher' ? $user->teacher : null;
        $assignedSections = $teacher ? $teacher->assigned_sections : [];

        $search = trim($request->input('search', ''));
        $status = $request->input('status');
        $section = $request->input('section');

        $query = Student::query();

        if ($user->role === 'teacher') {
            if (empty($assignedSections)) {
                $query->whereRaw('1 = 0');
            } elseif ($section && in_array($section, $assignedSections)) {
                $query->where('section', $section);
            } else {
                $query->whereIn('section', $assignedSections);
            }
        } elseif ($section) {
            $query->where('section', $section);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('student_no', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $students = $query->orderBy('last_name')->orderBy('first_name')->paginate(15)->withQueryString();

        return view('teacher.students.index', compact('students', 'search', 'status', 'section'));
    }

    /**
     * Display student profile for teachers.
     */
    public function teacherShow(Student $student)
    {

        $student->load([
            'attendances' => function ($query) {
                $query
                    ->orderByDesc('attendance_date')
                    ->orderByDesc('time_in');
            },
        ]);

        return view('teacher.students.show', compact('student'));
    }

    /**
     * Show create student form.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store new student.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_no' => 'required|string|max:50|unique:students,student_no',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gender' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'grade_level' => 'required|string|max:50',
            'section' => 'nullable|string|max:100',
            'qr_code' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:20',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Student Photo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request
                ->file('photo')
                ->store('students/photos', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Generate QR Code Value
        |--------------------------------------------------------------------------
        */

        if (empty($validated['qr_code'])) {
            $validated['qr_code'] = $validated['student_no'];
        }

        /*
        |--------------------------------------------------------------------------
        | Default Status
        |--------------------------------------------------------------------------
        */

        if (empty($validated['status'])) {
            $validated['status'] = 'Active';
        }

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student added successfully.');
    }

    /**
     * Display student profile for admin.
     */
    public function show(Student $student)
    {
        $student->load([
            'parents',
            'attendances' => function ($query) {
                $query
                    ->orderByDesc('attendance_date')
                    ->orderByDesc('time_in');
            },
        ]);

        return view('students.show', compact('student'));
    }

    /**
     * Show edit student form.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update student.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_no' => 'required|string|max:50|unique:students,student_no,' . $student->id,
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'gender' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'grade_level' => 'required|string|max:50',
            'section' => 'nullable|string|max:100',
            'qr_code' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:20',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Replace Existing Photo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            if (
                $student->photo &&
                Storage::disk('public')->exists($student->photo)
            ) {
                Storage::disk('public')->delete($student->photo);
            }

            $validated['photo'] = $request
                ->file('photo')
                ->store('students/photos', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Preserve Existing QR Code
        |--------------------------------------------------------------------------
        */

        if (empty($validated['qr_code'])) {
            $validated['qr_code'] =
                $student->qr_code ?: $student->student_no;
        }

        /*
        |--------------------------------------------------------------------------
        | Preserve Existing Status
        |--------------------------------------------------------------------------
        */

        if (empty($validated['status'])) {
            $validated['status'] = $student->status ?: 'Active';
        }

        $student->update($validated);

        return redirect()
            ->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Upload or update student photo directly.
     */
    public function updatePhoto(Request $request, Student $student)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Delete Old Photo
        |--------------------------------------------------------------------------
        */

        if (
            $student->photo &&
            Storage::disk('public')->exists($student->photo)
        ) {
            Storage::disk('public')->delete($student->photo);
        }

        /*
        |--------------------------------------------------------------------------
        | Store New Photo
        |--------------------------------------------------------------------------
        */

        $path = $request
            ->file('photo')
            ->store('students/photos', 'public');

        $student->update([
            'photo' => $path,
        ]);

        return back()->with(
            'success',
            'Student photo updated successfully.'
        );
    }

    /**
     * Delete student.
     */
    public function destroy(Student $student)
    {
        /*
        |--------------------------------------------------------------------------
        | Remove Parent Relationships
        |--------------------------------------------------------------------------
        */

        $student->parents()->detach();

        /*
        |--------------------------------------------------------------------------
        | Delete Student Photo
        |--------------------------------------------------------------------------
        */

        if (
            $student->photo &&
            Storage::disk('public')->exists($student->photo)
        ) {
            Storage::disk('public')->delete($student->photo);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Student
        |--------------------------------------------------------------------------
        */

        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Export students to CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = Student::query();

        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->orderBy('grade_level')
            ->orderBy('section')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $filename = 'students_export_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM

            fputcsv($file, [
                'Student ID',
                'First Name',
                'Last Name',
                'Middle Name',
                'Gender',
                'Birthdate',
                'Grade Level',
                'Section',
                'Status',
                'QR Code',
                'Enrolled Date',
            ]);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_no,
                    $student->first_name,
                    $student->last_name,
                    $student->middle_name ?? '',
                    $student->gender ?? '',
                    $student->birthdate ?? '',
                    $student->grade_level,
                    $student->section ?? '',
                    $student->status ?? 'Active',
                    $student->qr_code ?? $student->student_no,
                    $student->created_at ? $student->created_at->format('Y-m-d') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download CSV import template.
     */
    public function downloadTemplate()
    {
        $filename = 'student_import_template.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'student_no',
                'first_name',
                'last_name',
                'middle_name',
                'gender',
                'birthdate',
                'grade_level',
                'section',
                'status',
            ]);

            fputcsv($file, [
                'VIP-2026-0003',
                'Juan',
                'Dela Cruz',
                'Santos',
                'Male',
                '2018-05-12',
                '1',
                'Rizal',
                'Active',
            ]);

            fputcsv($file, [
                'VIP-2026-0004',
                'Maria Clara',
                'Reyes',
                'Mabini',
                'Female',
                '2018-09-20',
                '1',
                'Bonifacio',
                'Active',
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Batch import students from CSV.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if ($handle === false) {
            return back()->with('error', 'Unable to read the uploaded CSV file.');
        }

        $rawHeader = fgets($handle);
        if ($rawHeader === false) {
            fclose($handle);
            return back()->with('error', 'The uploaded CSV file is empty.');
        }

        $rawHeader = preg_replace('/^\xEF\xBB\xBF/', '', $rawHeader);

        $delimiters = [',', ';', "\t"];
        $chosenDelimiter = ',';
        $maxCount = 0;
        foreach ($delimiters as $d) {
            $count = substr_count($rawHeader, $d);
            if ($count > $maxCount) {
                $maxCount = $count;
                $chosenDelimiter = $d;
            }
        }

        $headers = str_getcsv(trim($rawHeader), $chosenDelimiter);
        $normalizedHeaders = [];
        foreach ($headers as $index => $h) {
            $clean = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', $h)));
            $normalizedHeaders[$clean] = $index;
        }

        $colStudentNo = $normalizedHeaders['studentno'] ?? $normalizedHeaders['studentid'] ?? $normalizedHeaders['idnumber'] ?? $normalizedHeaders['lrn'] ?? null;
        $colFirstName = $normalizedHeaders['firstname'] ?? $normalizedHeaders['first'] ?? null;
        $colLastName = $normalizedHeaders['lastname'] ?? $normalizedHeaders['last'] ?? null;
        $colMiddleName = $normalizedHeaders['middlename'] ?? $normalizedHeaders['middle'] ?? null;
        $colGender = $normalizedHeaders['gender'] ?? $normalizedHeaders['sex'] ?? null;
        $colBirthdate = $normalizedHeaders['birthdate'] ?? $normalizedHeaders['dob'] ?? $normalizedHeaders['birthday'] ?? null;
        $colGradeLevel = $normalizedHeaders['gradelevel'] ?? $normalizedHeaders['grade'] ?? $normalizedHeaders['level'] ?? null;
        $colSection = $normalizedHeaders['section'] ?? null;
        $colStatus = $normalizedHeaders['status'] ?? null;

        if ($colStudentNo === null || $colFirstName === null || $colLastName === null || $colGradeLevel === null) {
            fclose($handle);
            return back()->with('error', 'CSV header must include at least: student_no, first_name, last_name, and grade_level.');
        }

        $existingStudentNos = Student::pluck('student_no')->flip()->toArray();
        $importedCount = 0;
        $skippedDuplicates = [];
        $invalidRows = [];
        $rowNumber = 1;

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 0, $chosenDelimiter)) !== false) {
                $rowNumber++;

                if (empty(array_filter($row, fn($val) => trim($val) !== ''))) {
                    continue;
                }

                $studentNo = isset($row[$colStudentNo]) ? trim($row[$colStudentNo]) : '';
                $firstName = isset($row[$colFirstName]) ? trim($row[$colFirstName]) : '';
                $lastName = isset($row[$colLastName]) ? trim($row[$colLastName]) : '';
                $gradeLevel = isset($row[$colGradeLevel]) ? trim($row[$colGradeLevel]) : '';

                if (empty($studentNo) || empty($firstName) || empty($lastName) || empty($gradeLevel)) {
                    $invalidRows[] = "Row {$rowNumber}";
                    continue;
                }

                if (isset($existingStudentNos[$studentNo])) {
                    $skippedDuplicates[] = $studentNo;
                    continue;
                }

                $middleName = ($colMiddleName !== null && isset($row[$colMiddleName])) ? trim($row[$colMiddleName]) : null;
                $gender = ($colGender !== null && isset($row[$colGender])) ? trim($row[$colGender]) : null;
                $birthdate = ($colBirthdate !== null && isset($row[$colBirthdate])) ? trim($row[$colBirthdate]) : null;
                if ($birthdate) {
                    $timestamp = strtotime($birthdate);
                    $birthdate = $timestamp ? date('Y-m-d', $timestamp) : null;
                }
                $section = ($colSection !== null && isset($row[$colSection])) ? trim($row[$colSection]) : null;
                $status = ($colStatus !== null && isset($row[$colStatus]) && !empty(trim($row[$colStatus]))) ? trim($row[$colStatus]) : 'Active';

                Student::create([
                    'student_no' => $studentNo,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'middle_name' => $middleName ?: null,
                    'gender' => $gender ?: null,
                    'birthdate' => $birthdate ?: null,
                    'grade_level' => $gradeLevel,
                    'section' => $section ?: null,
                    'qr_code' => $studentNo,
                    'status' => ucfirst(strtolower($status)),
                ]);

                $existingStudentNos[$studentNo] = true;
                $importedCount++;
            }

            \Illuminate\Support\Facades\DB::commit();
            fclose($handle);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Error during CSV import: ' . $e->getMessage());
        }

        $message = "Batch import complete: {$importedCount} student(s) successfully enrolled.";
        if (count($skippedDuplicates) > 0) {
            $message .= " (" . count($skippedDuplicates) . " duplicates skipped: " . implode(', ', array_slice($skippedDuplicates, 0, 5)) . (count($skippedDuplicates) > 5 ? '...' : '') . ")";
        }

        return redirect()->route('students.index')->with('success', $message);
    }

    /**
     * Display printable student ID card badge layout.
     */
    public function badge(Student $student)
    {
        $student->load('parents');
        return view('students.badge', compact('student'));
    }

    /**
     * Display printable batch student ID card badges layout.
     */
    public function batchBadges(Request $request)
    {
        $query = Student::with('parents')->where('status', 'Active');

        if ($request->filled('grade_level')) {
            $query->where('grade_level', $request->grade_level);
        }

        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        $students = $query->orderBy('grade_level')
            ->orderBy('section')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $gradeLevels = Student::distinct()->pluck('grade_level')->filter()->values();
        $sections = Student::distinct()->pluck('section')->filter()->values();

        return view('students.batch-badges', compact('students', 'gradeLevels', 'sections'));
    }
}