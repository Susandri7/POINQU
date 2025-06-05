<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class NonaktifkanUserExpired extends Command
{
    protected $signature = 'user:nonaktifkan-expired';
    protected $description = 'Nonaktifkan user yang sudah expired';

    public function handle()
    {
        $now = Carbon::now();
        $jumlah = User::where('status_aktif', true)
            ->whereNotNull('aktif_sampai')
            ->where('aktif_sampai', '<', $now)
            ->update(['status_aktif' => false]);
        $this->info("$jumlah user telah dinonaktifkan.");
    }
}