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
        Schema::create('built_in_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->enum('question_type', ['text', 'single_choice', 'checkbox', 'likert_scale', 'slider', 'ranking', 'date', 'file_upload']); 
            $table->string('question_text');
            $table->json('question_options')->nullable(); // For types like select, checkbox, dropdown
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('built_in_questions');
    }
};
