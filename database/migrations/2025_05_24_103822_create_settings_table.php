<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // UMKM pemilik setting
            $table->string('parameter');
            $table->longText('nilai')->nullable(); // Support isi panjang seperti pesan-pesan
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'parameter']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('settings');
    }
};
