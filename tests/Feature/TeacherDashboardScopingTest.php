<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherDashboardScopingTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_dashboard_data_is_scoped_to_assigned_sections(): void
    {
        // 1. Create Teacher with assigned section 'Rizal'
        $teacherUser = User::factory()->create([
            'role' => 'teacher',
            'name' => 'Maria Santos',
            'email' => 'maria@vip.edu.ph',
        ]);

        $teacher = Teacher::create([
            'user_id' => $teacherUser->id,
            'employee_no' => 'EMP-0001',
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'section' => 'Rizal',
            'grade_level' => '1',
        ]);

        // 2. Create Students in assigned section 'Rizal' and unassigned section 'Bonifacio'
        $studentRizal = Student::create([
            'student_no' => 'STU-0001',
            'first_name' => 'Jose',
            'last_name' => 'Rizal',
            'grade_level' => '1',
            'section' => 'Rizal',
            'status' => 'Active',
        ]);

        $studentBonifacio = Student::create([
            'student_no' => 'STU-0002',
            'first_name' => 'Andres',
            'last_name' => 'Bonifacio',
            'grade_level' => '2',
            'section' => 'Bonifacio',
            'status' => 'Active',
        ]);

        // 3. Act: Visit Teacher Dashboard as teacherUser
        $response = $this->actingAs($teacherUser)->get(route('teacher.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('totalStudents', 1);
        $response->assertViewHas('students', function ($students) use ($studentRizal, $studentBonifacio) {
            return $students->contains('id', $studentRizal->id) && !$students->contains('id', $studentBonifacio->id);
        });
        $response->assertViewHas('sections', function ($sections) {
            return $sections->count() === 1 && $sections->contains('Rizal') && !$sections->contains('Bonifacio');
        });

        // HTML assertion: "All Sections" option should not exist in dropdown
        $response->assertDontSee('<option value="">All Sections</option>', false);

        // 4. Act: Check Live Data JSON API endpoint
        $liveResponse = $this->actingAs($teacherUser)->getJson(route('teacher.dashboard.live'));

        $liveResponse->assertStatus(200);
        $liveResponse->assertJson(['totalStudents' => 1]);
        $jsonStudents = $liveResponse->json('students');
        $this->assertCount(1, $jsonStudents);
        $this->assertEquals('STU-0001', $jsonStudents[0]['student_no']);

        // 5. Act: Attempt unauthorized attendance override for student in another section
        $overrideResponse = $this->actingAs($teacherUser)->post(route('teacher.attendance.status'), [
            'student_id' => $studentBonifacio->id,
            'attendance_date' => now()->toDateString(),
            'status' => 'Present',
        ]);

        $overrideResponse->assertStatus(403);
    }
}
