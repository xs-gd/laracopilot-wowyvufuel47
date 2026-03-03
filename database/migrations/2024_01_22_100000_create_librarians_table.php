<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('librarians', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('employee_id')->unique();
            $table->string('department');
            $table->string('specialization')->nullable();
            $table->string('phone')->nullable();
            $table->date('hire_date');
            $table->boolean('active')->default(true);
            $table->enum('role', [
                'librarian',
                'senior_librarian',
                'department_head',
                'reference_specialist',
                'cataloger',
                'systems_librarian',
                'archivist',
                'trainee'
            ])->default('librarian');
            $table->text('role_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('librarians');
    }
};