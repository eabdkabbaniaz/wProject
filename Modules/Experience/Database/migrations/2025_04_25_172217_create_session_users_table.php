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
        Schema::create('session_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'session_id')->constrained('sessions')->onDelete('cascade');
            $table->foreignId( 'user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('mark', 5, 2)->default(0.0);
              $table->string('report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_users');
    }
};
