<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ParentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyStudents = [
            // Grade 1
            [
                'student_no' => 'VIP-2026-0001',
                'first_name' => 'Zeus Raphael',
                'last_name' => 'Estacio',
                'middle_name' => 'Alfonso',
                'gender' => 'Male',
                'birthdate' => '2018-05-12',
                'grade_level' => '1',
                'section' => 'Rizal',
                'qr_code' => 'VIP-2026-0001',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Roberto',
                    'middle_name' => 'Alfonso',
                    'last_name' => 'Estacio',
                    'relationship' => 'Father',
                    'phone' => '09171234501',
                    'email' => 'roberto.estacio@example.com',
                    'address' => '123 Sampaguita St., Quezon City',
                ],
            ],
            [
                'student_no' => 'VIP-2026-0002',
                'first_name' => 'Julius',
                'last_name' => 'Lazaro',
                'middle_name' => 'Cruz',
                'gender' => 'Male',
                'birthdate' => '2018-09-20',
                'grade_level' => '1',
                'section' => 'Rizal',
                'qr_code' => 'VIP-2026-0002',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Maria',
                    'middle_name' => 'Cruz',
                    'last_name' => 'Lazaro',
                    'relationship' => 'Mother',
                    'phone' => '09171234502',
                    'email' => 'maria.lazaro@example.com',
                    'address' => '45 Mabini St., Quezon City',
                ],
            ],

            // Grade 2
            [
                'student_no' => 'VIP-2026-0003',
                'first_name' => 'Maria Clara',
                'last_name' => 'Santos',
                'middle_name' => 'Reyes',
                'gender' => 'Female',
                'birthdate' => '2017-03-15',
                'grade_level' => '2',
                'section' => 'Bonifacio',
                'qr_code' => 'VIP-2026-0003',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Juan',
                    'middle_name' => 'Reyes',
                    'last_name' => 'Santos',
                    'relationship' => 'Father',
                    'phone' => '09189876543',
                    'email' => 'juan.santos@example.com',
                    'address' => '78 Luna St., Pasig City',
                ],
            ],
            [
                'student_no' => 'VIP-2026-0004',
                'first_name' => 'Juan Pedro',
                'last_name' => 'Dela Cruz',
                'middle_name' => 'Garcia',
                'gender' => 'Male',
                'birthdate' => '2017-08-11',
                'grade_level' => '2',
                'section' => 'Bonifacio',
                'qr_code' => 'VIP-2026-0004',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Elena',
                    'middle_name' => 'Garcia',
                    'last_name' => 'Dela Cruz',
                    'relationship' => 'Mother',
                    'phone' => '09192345678',
                    'email' => 'elena.delacruz@example.com',
                    'address' => '12 Bonifacio Ave., Makati City',
                ],
            ],

            // Grade 3
            [
                'student_no' => 'VIP-2026-0005',
                'first_name' => 'Angela May',
                'last_name' => 'Bonifacio',
                'middle_name' => 'Villanueva',
                'gender' => 'Female',
                'birthdate' => '2016-01-22',
                'grade_level' => '3',
                'section' => 'Mabini',
                'qr_code' => 'VIP-2026-0005',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Antonio',
                    'middle_name' => 'Villanueva',
                    'last_name' => 'Bonifacio',
                    'relationship' => 'Father',
                    'phone' => '09203456789',
                    'email' => 'antonio.bonifacio@example.com',
                    'address' => '56 Rizal Rd., Taguig City',
                ],
            ],
            [
                'student_no' => 'VIP-2026-0006',
                'first_name' => 'Mark Joseph',
                'last_name' => 'Bautista',
                'middle_name' => 'Torres',
                'gender' => 'Male',
                'birthdate' => '2016-11-05',
                'grade_level' => '3',
                'section' => 'Mabini',
                'qr_code' => 'VIP-2026-0006',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Teresa',
                    'middle_name' => 'Torres',
                    'last_name' => 'Bautista',
                    'relationship' => 'Mother',
                    'phone' => '09214567890',
                    'email' => 'teresa.bautista@example.com',
                    'address' => '89 Katipunan St., Marikina City',
                ],
            ],

            // Grade 4
            [
                'student_no' => 'VIP-2026-0007',
                'first_name' => 'Sophia Joy',
                'last_name' => 'Garcia',
                'middle_name' => 'Mendoza',
                'gender' => 'Female',
                'birthdate' => '2015-06-18',
                'grade_level' => '4',
                'section' => 'Silang',
                'qr_code' => 'VIP-2026-0007',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Ricardo',
                    'middle_name' => 'Mendoza',
                    'last_name' => 'Garcia',
                    'relationship' => 'Father',
                    'phone' => '09225678901',
                    'email' => 'ricardo.garcia@example.com',
                    'address' => '34 Del Pilar St., Mandaluyong City',
                ],
            ],
            [
                'student_no' => 'VIP-2026-0008',
                'first_name' => 'Ethan James',
                'last_name' => 'Ramos',
                'middle_name' => 'Castillo',
                'gender' => 'Male',
                'birthdate' => '2015-04-30',
                'grade_level' => '4',
                'section' => 'Silang',
                'qr_code' => 'VIP-2026-0008',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Grace',
                    'middle_name' => 'Castillo',
                    'last_name' => 'Ramos',
                    'relationship' => 'Mother',
                    'phone' => '09236789012',
                    'email' => 'grace.ramos@example.com',
                    'address' => '90 Aurora Blvd., San Juan City',
                ],
            ],

            // Grade 5
            [
                'student_no' => 'VIP-2026-0009',
                'first_name' => 'Isabella Grace',
                'last_name' => 'Mendoza',
                'middle_name' => 'Aquino',
                'gender' => 'Female',
                'birthdate' => '2014-09-14',
                'grade_level' => '5',
                'section' => 'Luna',
                'qr_code' => 'VIP-2026-0009',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Ramon',
                    'middle_name' => 'Aquino',
                    'last_name' => 'Mendoza',
                    'relationship' => 'Father',
                    'phone' => '09247890123',
                    'email' => 'ramon.mendoza@example.com',
                    'address' => '15 Commonwealth Ave., Quezon City',
                ],
            ],
            [
                'student_no' => 'VIP-2026-0010',
                'first_name' => 'Gabriel Luis',
                'last_name' => 'Flores',
                'middle_name' => 'Dizon',
                'gender' => 'Male',
                'birthdate' => '2014-12-03',
                'grade_level' => '5',
                'section' => 'Luna',
                'qr_code' => 'VIP-2026-0010',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Carmen',
                    'middle_name' => 'Dizon',
                    'last_name' => 'Flores',
                    'relationship' => 'Mother',
                    'phone' => '09258901234',
                    'email' => 'carmen.flores@example.com',
                    'address' => '67 Shaw Blvd., Mandaluyong City',
                ],
            ],

            // Grade 6
            [
                'student_no' => 'VIP-2026-0011',
                'first_name' => 'Chloe Anne',
                'last_name' => 'Aquino',
                'middle_name' => 'Soriano',
                'gender' => 'Female',
                'birthdate' => '2013-02-28',
                'grade_level' => '6',
                'section' => 'Del Pilar',
                'qr_code' => 'VIP-2026-0011',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Fernando',
                    'middle_name' => 'Soriano',
                    'last_name' => 'Aquino',
                    'relationship' => 'Father',
                    'phone' => '09269012345',
                    'email' => 'fernando.aquino@example.com',
                    'address' => '43 Taft Ave., Manila',
                ],
            ],
            [
                'student_no' => 'VIP-2026-0012',
                'first_name' => 'Daniel Rex',
                'last_name' => 'Navarro',
                'middle_name' => 'Corpuz',
                'gender' => 'Male',
                'birthdate' => '2013-07-07',
                'grade_level' => '6',
                'section' => 'Del Pilar',
                'qr_code' => 'VIP-2026-0012',
                'status' => 'Active',
                'parent' => [
                    'first_name' => 'Sofia',
                    'middle_name' => 'Corpuz',
                    'last_name' => 'Navarro',
                    'relationship' => 'Mother',
                    'phone' => '09270123456',
                    'email' => 'sofia.navarro@example.com',
                    'address' => '88 Ortigas Ave., Pasig City',
                ],
            ],
        ];

        foreach ($dummyStudents as $data) {
            $parentData = $data['parent'] ?? null;
            unset($data['parent']);

            $student = Student::updateOrCreate(
                ['student_no' => $data['student_no']],
                $data
            );

            if ($parentData) {
                // Create or update Parent User Account
                $user = User::updateOrCreate(
                    ['email' => $parentData['email']],
                    [
                        'name' => trim($parentData['first_name'] . ' ' . $parentData['last_name']),
                        'password' => Hash::make('password'),
                        'role' => 'parent',
                    ]
                );

                // Create or update Parent Profile
                $parentProfile = ParentProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'first_name' => $parentData['first_name'],
                        'middle_name' => $parentData['middle_name'],
                        'last_name' => $parentData['last_name'],
                        'phone' => $parentData['phone'],
                        'address' => $parentData['address'],
                    ]
                );

                // Link Student and Parent in pivot table
                $student->parents()->sync([
                    $parentProfile->id => ['relationship' => $parentData['relationship']]
                ]);
            }
        }
    }
}

