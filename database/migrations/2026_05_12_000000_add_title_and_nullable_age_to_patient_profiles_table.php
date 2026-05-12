<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('patient_profiles', 'title')) {
                $table->string('title', 20)->nullable()->after('patient_id_string');
            }
            $table->integer('age')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('patient_profiles', 'title')) {
                $table->dropColumn('title');
            }
            $table->integer('age')->nullable(false)->change();
        });
    }
};
