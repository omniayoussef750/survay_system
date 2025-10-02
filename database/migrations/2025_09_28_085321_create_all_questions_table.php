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
        Schema::create('all_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys')->onDelete('cascade');

            $table->enum('question_type', ['text', 'single_choice', 'multiple_choice', 'slider', 'ranking']);
            $table->string('question_text');
            $table->json('question_options')->nullable(); // For types like select, checkbox, dropdown

            $table->enum('source_type', ['built_in', 'custom']);
            $table->unsignedBigInteger('source_id')->nullable(); // لو builtin → ID من built_in_questions
            $table->integer('order')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_questions');
    }
};
