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
            $table->foreignId('librarian_id')->constrained()->onDelete('cascade');
            $table->string('patron_name');
            $table->text('question');
            $table->text('answer')->nullable();
            $table->enum('type', ['directional', 'informational', 'research', 'reader_advisory', 'technology'])->default('informational');
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reference_transactions');
    }
};