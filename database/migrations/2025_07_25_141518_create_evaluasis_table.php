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
        Schema::create('evaluasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periode_evaluasi')->onDelete('cascade');

            // Nilai untuk setiap kriteria (sesuai data Excel)
            $table->decimal('c1_produktivitas', 8, 2)->nullable(); // Produktivitas Kerja (40%)
            $table->decimal('c2_tanggung_jawab', 8, 2)->nullable(); // Tanggung Jawab (20%)
            $table->decimal('c3_kehadiran', 8, 2)->nullable(); // Kehadiran (20%)
            $table->decimal('c4_pelanggaran', 8, 2)->nullable(); // Pelanggaran Disiplin (10%)
            $table->decimal('c5_terlambat', 8, 2)->nullable(); // Terlambat (10%)

            // Hasil perhitungan CPI
            $table->decimal('total_skor', 10, 5)->nullable();
            $table->integer('ranking')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            // Index untuk performa query
            $table->index(['user_id', 'periode_id']);
            $table->index('ranking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi');
    }
};
