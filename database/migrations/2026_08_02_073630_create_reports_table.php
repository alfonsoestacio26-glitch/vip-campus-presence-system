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
       Schema::create('reports', function(Blueprint $table){

    $table->id();


    $table->foreignId('generated_by')
          ->constrained('users')
          ->cascadeOnDelete();


    $table->string('report_type')
          ->nullable();


    $table->string('file_name')
          ->nullable();


    $table->dateTime('generated_at')
          ->nullable();


    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
