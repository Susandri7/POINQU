<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = ['user_id', 'slug', 'judul', 'gambar', 'konten', 'form_fields'];

    // Tambahkan ini:
    protected $casts = [
        'konten' => 'array',
        'form_fields' => 'array',
    ];
}