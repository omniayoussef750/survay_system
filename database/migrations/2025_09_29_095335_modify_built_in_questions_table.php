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
            $table->string('source_table')->nullable()->after('question_options');
            $table->string('depends_on')->nullable()->after('source_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('built_in_questions', function (Blueprint $table) {
            $table->dropColumn(['source_table', 'depends_on']);
        });
    }
};
