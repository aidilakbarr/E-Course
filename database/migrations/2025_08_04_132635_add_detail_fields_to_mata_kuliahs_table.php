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
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->string('kelas')->after('dosen_id');
            $table->unsignedInteger('kapasitas')->after('kelas');
            $table->string('hari')->after('kapasitas');
            $table->time('jam_mulai')->after('hari');
            $table->time('jam_selesai')->after('jam_mulai');
            $table->string('ruangan')->after('jam_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropColumn([
                'kelas',
                'kapasitas',
                'hari',
                'jam_mulai',
                'jam_selesai',
                'ruangan',
            ]);
        });
    }
};
