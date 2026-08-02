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
      Schema::create('attendance', function(Blueprint $table){

    $table->id();


    $table->foreignId('student_id')
          ->constrained()
          ->cascadeOnDelete();


    $table->foreignId('guard_id')
          ->constrained()
          ->cascadeOnDelete();


    $table->date('attendance_date');


    $table->time('time_in')
          ->nullable();


    $table->time('time_out')
          ->nullable();


    $table->enum('status',[
        'Present',
        'Late',
        'Absent'
    ])
    ->default('Present');


    $table->timestamps();


});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
