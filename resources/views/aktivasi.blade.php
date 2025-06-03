<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Halaman Aktivasi User UMKM
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar (copy dari dashboard) --}}
            <div class="w-full md:w-64">
                <div class="bg-black rounded-xl py-4 px-0 flex flex-col gap-1 shadow-md">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->routeIs('dashboard') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('aktivasi') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->routeIs('aktivasi') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 10.66l.84-.84V4a2 2 0 012-2h6a2 2 0 012 2v5.82l.84.84A3.97 3.97 0 0120 14.5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4 0-1.1.45-2.1 1.16-2.84z"/></svg>
                        Aktivasi UMKM
                    </a>
                    <a href="{{ route('backup.download') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->routeIs('backup.download') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
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
                </div>
            </div>

            {{-- Main Content --}}
            <div class="flex-1">
                <div class="bg-white border rounded-xl shadow p-6">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (count($users) === 0)
                        <p class="text-gray-500">Tidak ada user yang menunggu aktivasi.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left rounded-xl overflow-hidden">
                                <thead>
                                    <tr class="bg-yellow-400 text-gray-900">
                                        <th class="px-4 py-2">Nama</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Daftar Pada</th>
                                        <th class="px-4 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr class="border-b last:border-none">
                                        <td class="px-4 py-2">{{ $user->name }}</td>
                                        <td class="px-4 py-2">{{ $user->email }}</td>
                                        <td class="px-4 py-2">{{ $user->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-4 py-2">
                                            <form action="{{ route('aktivasi.proses', $user->id) }}" method="POST" onsubmit="return confirm('Aktifkan user ini?')">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">Aktifkan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>