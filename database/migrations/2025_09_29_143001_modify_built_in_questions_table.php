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
       
         Schema::table('built_in_questions', function (Blueprint $table) {
             \DB::statement("ALTER TABLE built_in_questions MODIFY question_type ENUM('text', 'multiple_choice', 'slider', 'checkbox', 'ranking','dropdown') NOT NULL");
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('built_in_questions', function (Blueprint $table) {
             \DB::statement("ALTER TABLE built_in_questions MODIFY question_type ENUM('text', 'multiple_choice', 'slider', 'checkbox', 'ranking') NOT NULL");
        });
    }
};
