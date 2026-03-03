<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reference_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('transaction_time', 8);  // stored as HH:MM:SS string — SQLite safe
            $table->foreignId('librarian_id')->constrained('librarians')->onDelete('restrict');
            $table->string('patron_type', 100);
            $table->string('channel', 50);           // in_person|phone|email|chat|virtual
            $table->string('transaction_type', 50);  // ready_reference|research|directional|...
            $table->string('subject_area', 200);
            $table->text('question_summary');
            $table->text('response_summary')->nullable();
            $table->text('resources_used')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->string('status', 20)->default('pending');          // pending|in_progress|closed|referred
            $table->string('complexity_level', 20)->default('simple'); // simple|moderate|complex
            $table->boolean('follow_up_required')->default(false);
            $table->text('notes')->nullable();
            $table->string('recorded_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_transactions');
    }
};