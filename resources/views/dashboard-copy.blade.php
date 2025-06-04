<x-app-layout>
    <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
        {{-- Header Profile --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
            <div class="flex items-center gap-4 w-full">
                <div class="w-28 h-28 rounded-full bg-blue-400 flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-md">
                    {{ strtoupper(Str::substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-semibold text-gray-900">{{ Auth::user()->name ?? 'User' }}</span>
                        @if(Auth::user()->email_verified_at)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586l-3.293-3.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                        @endif
                    </div>
                    <div class="mt-2">
                        <span class="inline-block bg-green-500 text-white text-xs rounded-full px-3 py-1">Verified</span>
                    </div>
                </div>
            </div>
            <div class="ml-auto">
                <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-blue-400 text-blue-600 bg-white rounded-lg hover:bg-blue-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5-5h2a2 2 0 002-2V7a2 2 0 00-2-2h-1.5"/></svg>
                    Homepage
                </a>
            </div>
        </div>

        {{-- Pengingat Aktivasi Member Baru --}}
        @if(!empty($pendingMembers) && count($pendingMembers) > 0)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded flex items-center gap-2">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/></svg>
            <span>
                <strong>{{ count($pendingMembers) }}</strong> member baru menunggu aktivasi!
            </span>
            <a href="{{ route('aktivasi') }}" class="ml-2 inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">Cek Sekarang</a>
        </div>
        @endif

        {{-- Alert --}}
        @if(session('status'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 flex items-center gap-2 rounded">
            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/></svg>
            <span>{{ session('status') }}</span>
        </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar Menu --}}
            <div class="w-full md:w-64">
                <div class="bg-black rounded-xl py-4 px-0 flex flex-col gap-1 shadow-md">
                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->routeIs('dashboard') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>
                    @if(Auth::user()->email === 'admin@poinqu.my.id')
                        <a href="{{ route('aktivasi') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('aktivasi') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 10.66l.84-.84V4a2 2 0 012-2h6a2 2 0 012 2v5.82l.84.84A3.97 3.97 0 0120 14.5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4 0-1.1.45-2.1 1.16-2.84z"/></svg>
                            Aktivasi UMKM
                        </a>
                        <a href="{{ route('backup.download') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('backup') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            Backup Data
                        </a>
                        <a href="{{ url('/admin/member') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('admin/member') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            Data Member
                        </a>
                        <a href="{{ url('/admin/settings') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('admin/settings') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2v-7a2 2 0 00-2-2zm-2 6a2 2 0 01-4 0"/></svg>
                            Pengaturan Landing Page
                        </a>
                    @else
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
                    @endif
                </div>
            </div>
            {{-- Main Content --}}
            <div class="flex-1 flex flex-col gap-6">
                @if(Auth::user()->email === 'admin@poinqu.my.id')
                    {{-- Admin Dashboard --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                        <div class="bg-white border rounded-xl shadow p-6 flex items-center gap-4">
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z"/></svg>
                            <div>
                                <div class="text-lg font-bold">{{ $totalMemberAktif ?? 0 }}</div>
                                <div class="text-gray-500">Member Aktif</div>
                            </div>
                        </div>
                        <div class="bg-white border rounded-xl shadow p-6 flex items-center gap-4">
                            <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                            <div>
                                <div class="text-lg font-bold">{{ $totalMemberNonaktif ?? 0 }}</div>
                                <div class="text-gray-500">Member Nonaktif</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border rounded-xl shadow p-6 mt-4">
                        <div class="font-semibold text-lg mb-3">Member akan Expired (30 hari - 1 hari lagi)</div>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">No</th>
                                        <th class="px-4 py-2 text-left">Nama</th>
                                        <th class="px-4 py-2 text-left">WhatsApp</th>
                                        <th class="px-4 py-2 text-left">Email</th>
                                        <th class="px-4 py-2 text-left">Tanggal Expired</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($membersExpiredSoon ?? [] as $i => $member)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $i+1 }}</td>
                                            <td class="px-4 py-2">{{ $member->nama }}</td>
                                            <td class="px-4 py-2">{{ $member->whatsapp }}</td>
                                            <td class="px-4 py-2">{{ $member->email }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($member->expired_at)->format('d-m-Y') }}</td>
                                            <td class="px-4 py-2">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">Segera Expired</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-gray-400">Tidak ada member yang masa aktifnya akan berakhir dalam 30 hari ke depan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    {{-- Dashboard UMKM --}}
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
                    <div class="bg-white border rounded-xl shadow p-6 mt-4">
                        <div class="font-semibold text-lg mb-3">Data Member</div>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-yellow-100">
                                        <th class="px-4 py-2 text-left">No</th>
                                        <th class="px-4 py-2 text-left">Nama</th>
                                        <th class="px-4 py-2 text-left">WhatsApp</th>
                                        <th class="px-4 py-2 text-left">Email</th>
                                        <th class="px-4 py-2 text-left">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($members ?? [] as $i => $member)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $i+1 }}</td>
                                            <td class="px-4 py-2">{{ $member->nama }}</td>
                                            <td class="px-4 py-2">{{ $member->whatsapp }}</td>
                                            <td class="px-4 py-2">{{ $member->email }}</td>
                                            <td class="px-4 py-2">{{ $member->poin }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-400">Belum ada data member.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>