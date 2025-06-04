<x-app-layout>
<div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
<x-app-header/>

    <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar Menu --}}
            <div class="w-full md:w-64">
                @if(Auth::user()->email === 'admin@poinqu.my.id')
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

                
                {{-- Contoh statistik/dashboard lainnya --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white border rounded-xl shadow p-6 flex items-center gap-4">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z"/></svg>
                        <div>
                            <div class="text-lg font-bold">{{ $totalMember ?? 0 }}</div>
                            <div class="text-gray-500">Total Member</div>
                        </div>
                    </div>
                    <div class="bg-white border rounded-xl shadow p-6 flex items-center gap-4">
                        <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                        <div>
                            <div class="text-lg font-bold">{{ $totalHadiah ?? 0 }}</div>
                            <div class="text-gray-500">Total Hadiah</div>
                        </div>
                    </div>
                    <div class="bg-white border rounded-xl shadow p-6 flex items-center gap-4">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-5a9 9 0 11-18 0a9 9 0 0118 0z"/></svg>
                        <div>
                            <div class="text-lg font-bold">{{ $totalTransaksi ?? 0 }}</div>
                            <div class="text-gray-500">Total Transaksi</div>
                        </div>
                    </div>
                </div>
                {{-- Area lain bisa ditambah di sini --}}
            </div>
        </div>
    </div>
</x-app-layout>