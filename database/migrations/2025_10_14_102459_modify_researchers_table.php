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
            $table->string('google_id')->after('is_active')->nullable();
            $table->string('facebook_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('researchers', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('facebook_id');

        });
    }
};
