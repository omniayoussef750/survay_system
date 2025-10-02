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
        Schema::table('all_questions', function (Blueprint $table) {
            $table->dropColumn('source_type');
            $table->dropColumn('source_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_questions', function (Blueprint $table) {
            $table->string('source_type')->nullable();
            $table->foreignId('source_id')->nullable()->constrained()->onDelete('set null');
        });
    }
};
