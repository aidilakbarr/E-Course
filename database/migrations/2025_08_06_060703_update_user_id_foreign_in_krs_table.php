<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('krs', function (Blueprint $table) {
            // Drop foreign key lama
            $table->dropForeign(['user_id']);

            // Rename kolom
            $table->renameColumn('user_id', 'mahasiswa_id');
        });

        Schema::table('krs', function (Blueprint $table) {
            // Tambahkan foreign key baru ke tabel mahasiswa
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('krs', function (Blueprint $table) {
            // Drop foreign key baru
            $table->dropForeign(['mahasiswa_id']);

            // Rename kembali ke user_id
            $table->renameColumn('mahasiswa_id', 'user_id');
        });

        Schema::table('krs', function (Blueprint $table) {
            // Kembalikan foreign key ke users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
