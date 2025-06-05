<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Landing Page
        </h2>
    </x-slot>
    <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar UMKM --}}
            <div class="w-full md:w-64">
                <div class="bg-black rounded-xl py-4 px-0 flex flex-col gap-1 shadow-md">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->routeIs('dashboard') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ url('/form-pendaftaran') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('form-pendaftaran') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 10.66l.84-.84V4a2 2 0 012-2h6a2 2 0 012 2v5.82l.84.84A3.97 3.97 0 0120 14.5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4 0-1.1.45-2.1 1.16-2.84z"/></svg>
                        Form Daftar Member
                    </a>
                    <a href="{{ url('/input-kode') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('input-kode') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        Input Kode Member
                    </a>
                    <a href="{{ url('/member') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('member') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Data Member
                    </a>
                    <a href="{{ url('/pengaturan') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('pengaturan') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2v-7a2 2 0 00-2-2zm-2 6a2 2 0 01-4 0"/></svg>
                        Pengaturan Hadiah & Poin
                    </a>
                    <a href="{{ url('/riwayat') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('riwayat') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Riwayat Poin
                    </a>
                    <a href="{{ route('landing.index') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->routeIs('landing.index') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2v-7a2 2 0 00-2-2zm-2 6a2 2 0 01-4 0"/></svg>
                        Kelola Landing Page
                    </a>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="flex-1">
                <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-xl p-8 border border-yellow-100">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Kelola Landing Page UMKM</h3>
                    <p class="text-gray-600 mb-4">Total: <span class="font-bold">{{ $total }}</span> dari <span class="font-bold">{{ $limit }}</span> halaman yang diperbolehkan</p>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
                    @endif

                    @if($total < $limit)
                        <form action="{{ route('landing.store') }}" method="POST" class="flex flex-col md:flex-row gap-3 items-center mb-6">
                            @csrf
                            <input type="text" name="slug" placeholder="Slug (contoh: warungbude)" required
                                class="flex-1 px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition shadow-sm">
                            <input type="text" name="judul" placeholder="Judul Landing Page" required
                                class="flex-1 px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 transition shadow-sm">
                            <button type="submit"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-lg shadow transition">+ Buat Landing Page</button>
                        </form>
                    @endif

                    <ul class="mt-4 space-y-3">
                        @forelse ($pages as $page)
                            <li class="flex flex-col md:flex-row md:items-center justify-between bg-yellow-50 hover:bg-yellow-100 px-4 py-2 rounded-lg mb-2">
                                <div>
                                    <a href="/{{ $page->slug }}" target="_blank" class="text-blue-700 font-bold hover:underline">{{ $page->slug }}</a>
                                    <span class="text-gray-700">– {{ $page->judul }}</span>
                                </div>
                                <div class="flex gap-2 mt-2 md:mt-0">
                                    <a href="{{ route('landing.edit', $page->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm shadow transition">Edit</a>
                                    <form action="{{ route('landing.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Yakin hapus halaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm shadow transition">Hapus</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-400">Belum ada landing page.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

