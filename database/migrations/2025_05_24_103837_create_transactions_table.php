<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->enum('tipe', ['tambah', 'tukar']);
            $table->integer('jumlah')->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamp('waktu_transaksi')->useCurrent();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
