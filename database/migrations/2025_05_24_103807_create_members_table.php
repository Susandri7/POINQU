<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID UMKM
            $table->string('kode_unik')->unique();
            $table->string('nama');
            $table->string('wa');
            $table->string('desa');
            $table->date('tanggal_lahir');
            $table->integer('poin')->default(0);
            $table->integer('total_poin')->default(0);
            $table->string('keterangan_ultah')->nullable();
            $table->timestamp('waktu_pendaftaran')->nullable();
            $table->timestamp('waktu_poin_terakhir')->nullable();
            $table->date('tanggal_pengingat_terakhir')->nullable();
            $table->integer('index_pesan_terakhir')->default(1);
            $table->integer('poin_ditukar')->default(0);
            $table->text('riwayat')->nullable();
            $table->timestamps();

         // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           
        });
    }

    public function down(): void {
        Schema::dropIfExists('members');
    }
};
