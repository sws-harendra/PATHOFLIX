<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('culture_results', function (Blueprint $table) {
            $table->string('growth_status')->nullable()->after('specimen');
        });
    }

    public function down(): void
    {
        Schema::table('culture_results', function (Blueprint $table) {
            $table->dropColumn('growth_status');
        });
    }
};
