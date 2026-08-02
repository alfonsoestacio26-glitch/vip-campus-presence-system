<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {

    $table->id();

    $table->string('student_no')
          ->unique();

    $table->string('first_name');

    $table->string('last_name');

    $table->string('middle_name')
          ->nullable();

    $table->enum('gender',[
        'Male',
        'Female'
    ])->nullable();


    $table->date('birthdate')
          ->nullable();


    $table->string('grade_level')
          ->nullable();


    $table->string('section')
          ->nullable();


    $table->string('qr_code')
          ->unique()
          ->nullable();


    $table->enum('status',[
        'Active',
        'Inactive'
    ])
    ->default('Active');


    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
