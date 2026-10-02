<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing teachers to match the 6 official school sections
        Schema::disableForeignKeyConstraints();
        Teacher::truncate();
        User::where('role', 'teacher')->delete();
        Schema::enableForeignKeyConstraints();

        $teachersData = [
            [
                'employee_no' => 'EMP-2026-0001',
                'first_name' => 'Maria Clara',
                'last_name' => 'Santos',
                'grade_level' => '1',
                'section' => 'Rizal',
                'email' => 'maria.santos@vip.edu.ph',
                'contact_number' => '09171110001',
            ],
            [
                'employee_no' => 'EMP-2026-0002',
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'grade_level' => '2',
                'section' => 'Bonifacio',
                'email' => 'juan.delacruz@vip.edu.ph',
                'contact_number' => '09171110002',
            ],
            [
                'employee_no' => 'EMP-2026-0003',
                'first_name' => 'Ana Patricia',
                'last_name' => 'Reyes',
                'grade_level' => '3',
                'section' => 'Mabini',
                'email' => 'ana.reyes@vip.edu.ph',
                'contact_number' => '09171110003',
            ],
            [
                'employee_no' => 'EMP-2026-0004',
                'first_name' => 'Gabriel',
                'last_name' => 'Mendoza',
                'grade_level' => '4',
                'section' => 'Silang',
                'email' => 'gabriel.mendoza@vip.edu.ph',
                'contact_number' => '09171110004',
            ],
            [
                'employee_no' => 'EMP-2026-0005',
                'first_name' => 'Sophia Beatrice',
                'last_name' => 'Garcia',
                'grade_level' => '5',
                'section' => 'Luna',
                'email' => 'sophia.garcia@vip.edu.ph',
                'contact_number' => '09171110005',
            ],
            [
                'employee_no' => 'EMP-2026-0006',
                'first_name' => 'Mark Anthony',
                'last_name' => 'Ramos',
                'grade_level' => '6',
                'section' => 'Del Pilar',
                'email' => 'mark.ramos@vip.edu.ph',
                'contact_number' => '09171110006',
            ],
        ];

        foreach ($teachersData as $data) {
            $user = User::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'employee_no' => $data['employee_no'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'grade_level' => $data['grade_level'],
                'section' => $data['section'],
                'contact_number' => $data['contact_number'],
            ]);
        }
    }
}
