<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'kode_unik',
        'nama',
        'wa',
        'desa',
        'tanggal_lahir',
        'poin',
        'total_poin',
        'keterangan_ultah',
        'waktu_pendaftaran',
        'waktu_poin_terakhir',
        'tanggal_pengingat_terakhir',
        'index_pesan_terakhir',
        'poin_ditukar',
        'riwayat'
    ];
}