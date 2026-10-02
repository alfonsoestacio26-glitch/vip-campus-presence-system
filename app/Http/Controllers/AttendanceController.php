<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Guard;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    /**
     * Display attendance records for Admin.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $date = $request->input('date');
        $status = $request->input('status');

        $query = Attendance::with([
                'student',
                'guardProfile'
            ])
            ->orderByDesc('attendance_date')
            ->orderByDesc('time_in');

        if ($search) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('student_no', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        if ($date) {
            $query->whereDate('attendance_date', $date);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $attendances = $query->paginate(20)->withQueryString();

        return view('attendance.index', compact('attendances', 'search', 'date', 'status'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $students = Student::orderBy('last_name')->orderBy('first_name')->get();
        $guards = Guard::orderBy('last_name')->orderBy('first_name')->get();

        return view('attendance.create', compact('students', 'guards'));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'guard_id' => ['nullable', 'exists:guards,id'],
            'attendance_date' => ['required', 'date'],
            'time_in' => ['nullable'],
            'time_out' => ['nullable'],
            'status' => ['required', 'in:Present,Late,Absent,present,late,absent'],
        ]);

        // Duplicate attendance check for the same student on the same date
        $duplicate = Attendance::where('student_id', $validated['student_id'])
            ->whereDate('attendance_date', $validated['attendance_date'])
            ->exists();

        if ($duplicate) {
            return back()->withErrors([
                'student_id' => 'An attendance record already exists for this student on the selected date.'
            ])->withInput();
        }

        // Time Out earlier than Time In check
        if (!empty($validated['time_in']) && !empty($validated['time_out'])) {
            if (strtotime($validated['time_out']) < strtotime($validated['time_in'])) {
                return back()->withErrors([
                    'time_out' => 'Time Out cannot be earlier than Time In.'
                ])->withInput();
            }
        }

        // Standardize status capitalization
        $validated['status'] = ucfirst(strtolower($validated['status']));

        Attendance::create($validated);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance record created successfully.');
    }

    /**
     * Display the specified attendance record.
     */
    public function show(Attendance $attendance)
    {
        $attendance->load(['student', 'guardProfile']);

        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified attendance record.
     */
    public function edit(Attendance $attendance)
    {
        $students = Student::orderBy('last_name')->orderBy('first_name')->get();
        $guards = Guard::orderBy('last_name')->orderBy('first_name')->get();

        return view('attendance.edit', compact('attendance', 'students', 'guards'));
    }

    /**
     * Update the specified attendance record in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'guard_id' => ['nullable', 'exists:guards,id'],
            'attendance_date' => ['required', 'date'],
            'time_in' => ['nullable'],
            'time_out' => ['nullable'],
            'status' => ['required', 'in:Present,Late,Absent,present,late,absent'],
        ]);

        // Duplicate attendance check excluding current record
        $duplicate = Attendance::where('student_id', $validated['student_id'])
            ->whereDate('attendance_date', $validated['attendance_date'])
            ->where('id', '!=', $attendance->id)
            ->exists();

        if ($duplicate) {
            return back()->withErrors([
                'student_id' => 'An attendance record already exists for this student on the selected date.'
            ])->withInput();
        }

        // Time Out earlier than Time In check
        if (!empty($validated['time_in']) && !empty($validated['time_out'])) {
            if (strtotime($validated['time_out']) < strtotime($validated['time_in'])) {
                return back()->withErrors([
                    'time_out' => 'Time Out cannot be earlier than Time In.'
                ])->withInput();
            }
        }

        // Standardize status capitalization
        $validated['status'] = ucfirst(strtolower($validated['status']));

        $attendance->update($validated);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified attendance record from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * Display attendance records for Teachers.
     *
     * Teachers can monitor attendance but cannot create,
     * update, or delete attendance records.
     */
    public function teacherIndex(Request $request)
    {
        $user = auth()->user();
        $teacher = $user->role === 'teacher' ? $user->teacher : null;

        $query = Attendance::with('student')
            ->orderByDesc('attendance_date')
            ->orderByDesc('time_in');

        if ($teacher) {
            $assignedSections = $teacher->assigned_sections;
            if (!empty($assignedSections)) {
                $query->whereHas('student', function ($q) use ($assignedSections) {
                    $q->whereIn('section', $assignedSections);
                });
            } else {
                $query->whereRaw('1 = 0');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Search Student
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->whereHas('student', function ($q) use ($search) {

                $q->where('student_no', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw(
                        "CONCAT(first_name, ' ', last_name) LIKE ?",
                        ["%{$search}%"]
                    );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter By Date
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            $query->whereDate(
                'attendance_date',
                $request->date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter By Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Get Records
        |--------------------------------------------------------------------------
        */

        $attendances = $query
            ->paginate(20)
            ->withQueryString();

        return view(
            'teacher.attendance.index',
            compact('attendances')
        );
    }

    /**
     * Scan a student's QR code.
     *
     * First scan  = Time In
     * Second scan = Time Out
     * Third scan  = Already completed
     */
    public function scan(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate QR Code
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'qr_code' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $scannedCode = trim($validated['qr_code']);

        /*
        |--------------------------------------------------------------------------
        | Find Guard
        |--------------------------------------------------------------------------
        */

        $guard = Guard::where(
            'user_id',
            Auth::id()
        )->first();

        /*
        | Keep fallback temporarily for testing.
        | Remove this fallback once Guard authentication is finalized.
        */

        if (!$guard) {
            $guard = Guard::first();
        }

        if (!$guard) {

            return response()->json([
                'success' => false,
                'message' => 'Guard profile not found in system.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Find Student
        |--------------------------------------------------------------------------
        */

        $student = Student::where(
            'qr_code',
            $scannedCode
        )
        ->orWhere(
            'student_no',
            $scannedCode
        )
        ->first();

        /*
        |--------------------------------------------------------------------------
        | Optional Partial QR Match
        |--------------------------------------------------------------------------
        |
        | This keeps your previous scanner behavior.
        |
        */

        if (!$student && strlen($scannedCode) >= 3) {

            $student = Student::whereRaw(
                '? LIKE CONCAT("%", student_no, "%")',
                [$scannedCode]
            )
            ->orWhereRaw(
                '? LIKE CONCAT("%", qr_code, "%")',
                [$scannedCode]
            )
            ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Student Not Found
        |--------------------------------------------------------------------------
        */

        if (!$student) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Scanned code "' .
                    Str::limit($scannedCode, 25) .
                    '" does not match any registered student.',
                'scanned_code' => $scannedCode,
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Today's Attendance
        |--------------------------------------------------------------------------
        */

        $today = \Carbon\Carbon::now('Asia/Manila')->toDateString();

        $attendance = Attendance::where(
            'student_id',
            $student->id
        )
        ->whereDate(
            'attendance_date',
            $today
        )
        ->first();

        /*
        |--------------------------------------------------------------------------
        | FIRST SCAN → TIME IN
        |--------------------------------------------------------------------------
        */

        if (!$attendance) {

            $attendance = Attendance::create([
                'student_id' => $student->id,
                'guard_id' => $guard->id,
                'attendance_date' => $today,
                'time_in' => now(),
                'time_out' => null,
                'status' => 'Present',
            ]);

            return response()->json([
                'success' => true,
                'type' => 'time_in',
                'message' => 'Time in recorded successfully.',

                'student' => [
                    'id' => $student->id,
                    'student_no' => $student->student_no,
                    'name' => $this->studentName($student),
                    'grade_level' => $student->grade_level,
                    'section' => $student->section,
                    'photo_url' => $student->photo_url,
                ],

                'attendance' => [
                    'date' => $attendance->attendance_date
                        ? $attendance->attendance_date->format('F d, Y')
                        : null,

                    'time_in' => $attendance->time_in
                        ? $attendance->time_in->format('h:i:s A')
                        : null,

                    'time_out' => null,

                    'status' => $attendance->status,
                ],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SECOND SCAN → TIME OUT
        |--------------------------------------------------------------------------
        */

        if (!$attendance->time_out) {

            $attendance->update([
                'time_out' => now(),
            ]);

            $attendance->refresh();

            return response()->json([
                'success' => true,
                'type' => 'time_out',
                'message' => 'Time out recorded successfully.',

                'student' => [
                    'id' => $student->id,
                    'student_no' => $student->student_no,
                    'name' => $this->studentName($student),
                    'grade_level' => $student->grade_level,
                    'section' => $student->section,
                    'photo_url' => $student->photo_url,
                ],

                'attendance' => [
                    'date' => $attendance->attendance_date
                        ? $attendance->attendance_date->format('F d, Y')
                        : null,

                    'time_in' => $attendance->time_in
                        ? $attendance->time_in->format('h:i:s A')
                        : null,

                    'time_out' => $attendance->time_out
                        ? $attendance->time_out->format('h:i:s A')
                        : null,

                    'status' => $attendance->status,
                ],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | THIRD+ SCAN → ALREADY COMPLETED
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => false,
            'type' => 'completed',
            'message' => 'Attendance already completed for today.',

            'student' => [
                'id' => $student->id,
                'student_no' => $student->student_no,
                'name' => $this->studentName($student),
                'grade_level' => $student->grade_level,
                'section' => $student->section,
                'photo_url' => $student->photo_url,
            ],

            'attendance' => [
                'date' => $attendance->attendance_date
                    ? $attendance->attendance_date->format('F d, Y')
                    : null,

                'time_in' => $attendance->time_in
                    ? $attendance->time_in->format('h:i A')
                    : null,

                'time_out' => $attendance->time_out
                    ? $attendance->time_out->format('h:i A')
                    : null,

                'status' => $attendance->status,
            ],
        ], 409);
    }

    /**
     * Generate student's full name.
     */
    private function studentName(Student $student): string
    {
        return trim(
            $student->first_name . ' ' .
            ($student->middle_name
                ? $student->middle_name . ' '
                : '') .
            $student->last_name
        );
    }
}