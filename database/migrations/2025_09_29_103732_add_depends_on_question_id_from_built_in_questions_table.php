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
           $table->unsignedBigInteger('depends_on_question_id')->nullable()->after('source_table');
           $table->foreign('depends_on_question_id')
                ->references('id')
                ->on('built_in_questions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('built_in_questions', function (Blueprint $table) {
            $table->dropForeign(['depends_on_question_id']);
            $table->dropColumn('depends_on_question_id');
        });
    }
};
