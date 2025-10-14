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
        Schema::table('researchers', function (Blueprint $table) {
            $table->unique('facebook_id');
            $table->unique('google_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('researchers', function (Blueprint $table) {
            $table->dropUnique('facebook_id');
            $table->dropUnique('google_id');
        });
    }
};
