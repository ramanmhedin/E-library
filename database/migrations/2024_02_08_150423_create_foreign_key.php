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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('subject_id')->nullable()->constrained('subjects');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('college_id')->nullable()->constrained('colleges');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('college_id')->constrained('colleges');
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('college_id')->constrained('colleges');
        });

        Schema::table('research', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('teacher_id')->constrained('users');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('administer_id')->constrained('users');
            $table->foreignId('college_id')->constrained('colleges');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreignId('research_id')->constrained('research');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foreign_key');
    }
};
