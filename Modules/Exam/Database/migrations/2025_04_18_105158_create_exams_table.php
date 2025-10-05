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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number_of_questions');
            $table->double('Final_grade');
            $table->double('time');
            $table-> date('Start_date');
            $table->date('End_date');
            $table->boolean('status')->default(false);
            // $table->foreignId( 'subject_id')->constrained('subjects');
            $table->foreignId( 'teacher_id')->constrained('users');
            $table->timestamps();
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
