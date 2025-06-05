<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Landing Page UMKM
        </h2>
    </x-slot>
    <div class="min-h-screen bg-[#f6f5ef] py-8 px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl p-8 border border-yellow-100">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar UMKM & Limit Landing Page</h3>
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            <div class="overflow-x-auto">
                <table class="w-full text-left rounded-xl overflow-hidden">
                    <thead>
                        <tr class="bg-yellow-400 text-gray-900">
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Limit Landing Page</th>
                            <th class="px-4 py-2">Tambah Limit</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b last:border-none">
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2 text-center">{{ $user->max_pages ?? 0 }}</td>
                            <td class="px-4 py-2 text-center">
                                <div x-data="{ openModalLimit: false }" class="inline-block">
                                    <button
                                        type="button"
                                        @click="openModalLimit = true"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition"
                                    >
                                        Tambah
                                    </button>
                                    <div
                                        x-show="openModalLimit"
                                        x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                                    >
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xs">
                                            <h2 class="text-lg font-semibold mb-3 text-gray-800">
                                                Tambah Limit Landing Page
                                            </h2>
                                            <form
                                                action="{{ route('admin.landing_settings.update_max_pages', $user->id) }}"
                                                method="POST"
                                                class="flex flex-col gap-2"
                                            >
                                                @csrf
                                                <div class="mb-2">
                                                    <label class="block text-sm text-gray-600 mb-1">Tambah Jumlah</label>
                                                    <input type="number" min="1" name="jumlah" class="border rounded px-2 py-1 w-full" value="1" required>
                                                    <div class="text-xs text-gray-500 mt-1">Limit saat ini: <b>{{ $user->max_pages ?? 0 }}</b></div>
                                                </div>
                                                <div class="flex justify-end gap-2 mt-3">
                                                    <button
                                                        @click.prevent="openModalLimit = false"
                                                        type="button"
                                                        class="px-4 py-2 rounded border border-gray-300 bg-gray-100 text-gray-700 hover:bg-gray-200 transition"
                                                    >Batal</button>
                                                    <button
                                                        type="submit"
                                                        class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded transition"
                                                    >
                                                        Tambah Limit
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-gray-400 py-4">Belum ada UMKM</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>[x-cloak] { display: none !important; }</style>
</x-app-layout>