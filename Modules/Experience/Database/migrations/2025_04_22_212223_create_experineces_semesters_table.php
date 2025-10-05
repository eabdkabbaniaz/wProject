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
        Schema::create('experineces_semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId( column: 'experience_id')->constrained('experiences')->onDelete('cascade');
            $table->foreignId( column: 'semester_id')->constrained('semesters')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
