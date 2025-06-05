<x-app-layout>
    <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
        <x-app-header />
        <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="w-full md:w-64">
                   
                    @if(Auth::user()->role === 'admin')
                    
                        <x-sidebar-admin />
                    @else
                        <x-sidebar-umkm />
                    @endif
                </div>
                <div class="flex-1">
                    <div class="bg-white border rounded-xl shadow p-6">
                        <h2 class="text-xl font-bold mb-4">UMKM Menjelang Expired (3 Bulan ke Depan)</h2>
                        @if (session('success'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (count($users) === 0)
                            <p class="text-gray-500">Tidak ada UMKM yang akan expired dalam 3 bulan ke depan.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left rounded-xl overflow-hidden">
                                    <thead>
                                        <tr class="bg-yellow-400 text-gray-900">
                                            <th class="px-4 py-2">Nama</th>
                                            <th class="px-4 py-2">Email</th>
                                            <th class="px-4 py-2">No WA</th>
                                            <th class="px-4 py-2">Expired</th>
                                            <th class="px-4 py-2">Aksi</th>
                                            <th class="px-4 py-2">Perpanjang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                        @php
                                            $isExpired = $user->aktif_sampai && \Carbon\Carbon::parse($user->aktif_sampai)->lt(now());
                                        @endphp
                                        <tr class="border-b last:border-none">
                                            <td class="px-4 py-2">{{ $user->name }}</td>
                                            <td class="px-4 py-2">{{ $user->email }}</td>
                                            <td class="px-4 py-2">{{ $user->no_wa ?? '-' }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($user->aktif_sampai)->format('d M Y H:i') }}</td>
                                            <td class="px-4 py-2">
                                                <div x-data="{ openModal: false }" class="inline-block">
                                                    <button
                                                        type="button"
                                                        @click="openModal = true"
                                                        class="{{ $user->status_aktif ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded transition"
                                                    >
                                                        {{ $user->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                    <div
                                                        x-show="openModal"
                                                        x-cloak
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                                                    >
                                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xs">
                                                            <h2 class="text-lg font-semibold mb-3 text-gray-800">
                                                                Konfirmasi
                                                            </h2>
                                                            <p class="mb-4 text-gray-700">
                                                                {{ $user->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }} user <b>{{ $user->name }}</b>?
                                                            </p>
                                                            <form
                                                                action="{{ route('aktivasi.proses', $user->id) }}"
                                                                method="POST"
                                                                class="flex flex-col gap-2"
                                                            >
                                                                @csrf
                                                                @if(!$user->status_aktif)
                                                                <div class="mb-2">
                                                                    <label class="block text-sm text-gray-600 mb-1">Masa Aktif</label>
                                                                    <div class="flex items-center gap-2">
                                                                        <input type="number" min="1" name="durasi" class="border rounded px-2 py-1 w-16" value="1" required>
                                                                        <select name="satuan" class="border rounded px-2 py-1">
                                                                            <option value="menit">Menit</option>
                                                                            <option value="jam">Jam</option>
                                                                            <option value="hari" selected>Hari</option>
                                                                            <option value="bulan">Bulan</option>
                                                                            <option value="tahun">Tahun</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="flex justify-end gap-2 mt-3">
                                                                    <button
                                                                        @click.prevent="openModal = false"
                                                                        type="button"
                                                                        class="px-4 py-2 rounded border border-gray-300 bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
                                                                    >Batal</button>
                                                                    <input type="hidden" name="aksi" value="{{ $user->status_aktif ? 'nonaktifkan' : 'aktifkan' }}">
                                                                    <button
                                                                        type="submit"
                                                                        class="{{ $user->status_aktif ? 'bg-red-500 hover:bg-red-700' : 'bg-green-500 hover:bg-green-700' }} text-white px-4 py-2 rounded transition"
                                                                    >
                                                                        Ya, {{ $user->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                @if($user->status_aktif || $isExpired)
                                                <div x-data="{ openModalPerpanjang: false }" class="inline-block">
                                                    <button
                                                        type="button"
                                                        @click="openModalPerpanjang = true"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition"
                                                    >
                                                        Perpanjang
                                                    </button>
                                                    <div
                                                        x-show="openModalPerpanjang"
                                                        x-cloak
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                                                    >
                                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xs">
                                                            <h2 class="text-lg font-semibold mb-3 text-gray-800">
                                                                Perpanjang Masa Aktif
                                                            </h2>
                                                            <form
                                                                action="{{ route('aktivasi.perpanjang', $user->id) }}"
                                                                method="POST"
                                                                class="flex flex-col gap-2"
                                                            >
                                                                @csrf
                                                                <div class="mb-2">
                                                                    <label class="block text-sm text-gray-600 mb-1">Tambah Durasi</label>
                                                                    <div class="flex items-center gap-2">
                                                                        <input type="number" min="1" name="durasi" class="border rounded px-2 py-1 w-16" value="1" required>
                                                                        <select name="satuan" class="border rounded px-2 py-1">
                                                                            <option value="menit">Menit</option>
                                                                            <option value="jam">Jam</option>
                                                                            <option value="hari" selected>Hari</option>
                                                                            <option value="bulan">Bulan</option>
                                                                            <option value="tahun">Tahun</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="flex justify-end gap-2 mt-3">
                                                                    <button
                                                                        @click.prevent="openModalPerpanjang = false"
                                                                        type="button"
                                                                        class="px-4 py-2 rounded border border-gray-300 bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
                                                                    >Batal</button>
                                                                    <button
                                                                        type="submit"
                                                                        class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded transition"
                                                                    >
                                                                        Proses Perpanjang
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
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
    </div>
</x-app-layout>
<style>[x-cloak] { display: none !important; }</style>