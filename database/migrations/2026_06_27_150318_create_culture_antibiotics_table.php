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
        Schema::create('culture_antibiotics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('culture_result_id')->constrained()->cascadeOnDelete();
            $table->string('antibiotic_name');
            $table->enum('sensitivity', ['Sensitive', 'Intermediate', 'Resistant', ''])->nullable();
            $table->string('mic_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culture_antibiotics');
    }
};
