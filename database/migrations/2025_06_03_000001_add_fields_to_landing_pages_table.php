<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('judul');
            $table->json('konten')->nullable()->after('gambar');
            $table->json('form_fields')->nullable()->after('konten');
        });
    }
    public function down(): void {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'konten', 'form_fields']);
        });
    }
};