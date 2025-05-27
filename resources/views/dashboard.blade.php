<x-app-layout> <x-slot name="header"> <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Dashboard {{ Auth::user()->email === 'admin@poinqu.my.id' ? 'Admin' : 'UMKM' }} </h2> </x-slot>

<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white p-6 shadow rounded">

        {{-- Untuk Admin --}}
        @if(Auth::user()->email === 'admin@poinqu.my.id')
            <h3 class="text-lg font-bold mb-3">Menu Admin</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li><a href="{{ route('aktivasi') }}" class="text-blue-600 hover:underline">Aktivasi UMKM</a></li>
                {{-- ✅ Tombol Backup Manual --}}

<li> <a href="{{ route('backup.download') }}" class="text-blue-600 hover:underline">📦 Backup Sekarang</a> </li>

@if(session('error'))
<div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
{{ session('error') }}
</div>
@endif



                <li><a href="{{ url('/form-preview') }}" class="text-blue-600 hover:underline">Preview Landing Page</a></li>
                <li><a href="{{ url('/admin/member') }}" class="text-blue-600 hover:underline">Semua Data Member</a></li>
                <li><a href="{{ url('/admin/settings') }}" class="text-blue-600 hover:underline">Atur Maksimal Landing Page</a></li>
            </ul>
            
        @else
        {{-- Untuk UMKM --}}
            <h3 class="text-lg font-bold mb-3">Menu UMKM</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li><a href="{{ url('/form-pendaftaran') }}" class="text-blue-600 hover:underline">Form Daftar Member</a></li>
                <li><a href="{{ url('/input-kode') }}" class="text-blue-600 hover:underline">Input Kode Member (Tambah Poin)</a></li>
                <li><a href="{{ url('/member') }}" class="text-blue-600 hover:underline">Data Member</a></li>
                <li><a href="{{ url('/pengaturan') }}" class="text-blue-600 hover:underline">Pengaturan Hadiah & Poin</a></li>
                <li><a href="{{ url('/riwayat') }}" class="text-blue-600 hover:underline">Riwayat Poin</a></li>
                <li><a href="{{ url('/backup') }}" class="text-blue-600 hover:underline">Backup Data</a></li>
                <li><a href="{{ route('landing.index') }}" class="text-blue-600 hover:underline">Kelola Landing Page</a></li>
            </ul>
        @endif
     
    </div>
</div>
</x-app-layout>
