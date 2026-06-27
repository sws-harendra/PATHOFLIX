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
        Schema::create('culture_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_item_id')->nullable()->constrained('invoice_items')->nullOnDelete();
            $table->foreignId('lab_test_id')->constrained('lab_tests')->cascadeOnDelete();
            $table->string('specimen')->nullable();
            $table->string('incubation_period')->nullable();
            $table->string('organism_name')->nullable();
            $table->string('colony_count')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culture_results');
    }
};
