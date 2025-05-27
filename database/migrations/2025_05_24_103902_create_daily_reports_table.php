<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('hari'); // Senin, Selasa, ...
            $table->date('tanggal');
            $table->integer('pendaftar_baru')->default(0);
            $table->integer('repeat_order')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'tanggal']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('daily_reports');
    }
};
