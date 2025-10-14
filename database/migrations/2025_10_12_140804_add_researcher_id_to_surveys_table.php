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
        Schema::table('surveys', function (Blueprint $table) {
           
            $table->foreignId('researcher_id')
                ->after('project_id')
                ->nullable()
                ->constrained('researchers')
                ->nullOnDelete(); 
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropForeign(['researcher_id']);
            $table->dropColumn('researcher_id');
        });
    }
};
