<x-app-layout>
@php
    if (!isset($umkmExpSoon)) $umkmExpSoon = collect();
@endphp

<div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
<x-app-header/>

   

    <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar Menu --}}
            <div class="w-full md:w-64">
                @if(Auth::user()->role === 'admin')
                    <x-sidebar-admin />
                @else
                    <x-sidebar-umkm />
                @endif
            </div>

            {{-- Main Content --}}
            <div class="flex-1 flex flex-col gap-6">
                <div class="bg-white border rounded-xl shadow p-6 mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name ?? 'User' }}</h3>
                    <p class="text-gray-600 text-lg">Ini adalah halaman dashboard utama aplikasi Anda.</p>
                </div>


                @if(Auth::user()->role === 'admin')
                {{-- Kartu Statistik UMKM 2 baris, 2 kolom --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Baris 1 --}}
                    <a href="{{ route('umkm.index') }}" class="bg-white border rounded-xl shadow p-6 flex items-center gap-4 transition hover:bg-green-50 cursor-pointer">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z"/></svg>
                        <div>
                            <div class="text-lg font-bold">{{ $totalUmkm ?? 0 }}</div>
                            <div class="text-gray-500">Total UMKM</div>
                        </div>
                    </a>
                    <a href="{{ route('umkm.expiring') }}" class="bg-white border rounded-xl shadow p-6 flex items-center gap-4 transition hover:bg-yellow-50 cursor-pointer">
                        <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                        <div>
                            <div class="text-lg font-bold">{{ $totalUmkmExpSoon ?? 0 }}</div>
                            <div class="text-gray-500">Total UMKM Menjelang Expired (3 bulan)</div>
                        </div>
                    </a>
                    {{-- Baris 2 --}}
                    <a href="{{ route('umkm.expired') }}" class="bg-white border rounded-xl shadow p-6 flex items-center gap-4 transition hover:bg-blue-50 cursor-pointer">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-5a9 9 0 11-18 0a9 9 0 0118 0z"/></svg>
                        <div>
                            <div class="text-lg font-bold">{{ $totalUmkmExpired ?? 0 }}</div>
                            <div class="text-gray-500">Total UMKM yang Expired</div>
                        </div>
                    </a>
                    <a href="{{ route('umkm.pending') }}" class="bg-white border rounded-xl shadow p-6 flex items-center gap-4 transition hover:bg-gray-50 cursor-pointer">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12h4v4"/></svg>
                        <div>
                            <div class="text-lg font-bold">{{ $totalUmkmPending ?? 0 }}</div>
                            <div class="text-gray-500">Total UMKM Menunggu Aktivasi</div>
                        </div>
                    </a>
                </div>

                @endif




                {{-- Bagian lama: List UMKM yang akan expired dalam 3 bulan --}}
                @if(Auth::user()->role === 'admin')
                    @if($umkmExpSoon->count())
                        <div class="bg-yellow-50 border-l-4 border-yellow-600 p-4 mb-6 rounded-xl">
                            <strong>UMKM/Member yang akan expired dalam 3 bulan ke depan:</strong>
                            <table class="min-w-full mt-3 text-sm">
                                <thead>
                                    <tr>
                                        <th class="px-2 py-1">Nama</th>
                                        <th class="px-2 py-1">Email</th>
                                        <th class="px-2 py-1">No WA</th>
                                        <th class="px-2 py-1">Expired</th>
                                        <th class="px-2 py-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($umkmExpSoon as $user)
                                    <tr>
                                        <td class="px-2 py-1">{{ $user->name }}</td>
                                        <td class="px-2 py-1">{{ $user->email }}</td>
                                        <td class="px-2 py-1">{{ $user->no_wa ?? '-' }}</td>
                                        <td class="px-2 py-1">{{ \Carbon\Carbon::parse($user->aktif_sampai)->format('d M Y H:i') }}</td>
                                        <td class="px-2 py-1">
                                            @php
                                                $waNumber = $user->no_wa ? preg_replace('/[^0-9]/', '', $user->no_wa) : '';
                                                if($waNumber && str_starts_with($waNumber, '0')) $waNumber = '62' . substr($waNumber, 1);
                                                $msg = urlencode("Halo $user->name, masa aktif akun Anda akan berakhir pada ".\Carbon\Carbon::parse($user->aktif_sampai)->format('d M Y H:i').". Silakan perpanjang untuk tetap dapat menggunakan layanan.");
                                                $waLink = $waNumber ? "https://wa.me/$waNumber?text=$msg" : '';
                                            @endphp
                                            @if($waLink)
                                                <a href="{{ $waLink }}" target="_blank" class="inline-block bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                                    Kirim WA
                                                </a>
                                            @else
                                                <span class="text-gray-400">No WA tidak ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-600 p-4 mb-6 rounded">
                            <em>Tidak ada UMKM/member yang akan expired dalam 3 bulan ke depan.</em>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>