<x-app-layout> <x-slot name="header"> <h2 class="text-xl font-bold">Pengaturan Aplikasi</h2> </x-slot>
<div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white p-6 rounded shadow space-y-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif

        {{-- Tombol kategori --}}
        <div class="flex flex-wrap gap-3">
            <button onclick="showForm('batas-poin')" class="btn-kategori">Batas Poin</button>
            <button onclick="showForm('pesan-poin')" class="btn-kategori">Pesan Hadiah</button>
            <button onclick="showForm('pengingat')" class="btn-kategori">Pesan Pengingat</button>
            <button onclick="showForm('hadiah')" class="btn-kategori">Hadiah & Harga</button>
            <button onclick="showForm('lainnya')" class="btn-kategori">Lainnya</button>
            <button onclick="showForm('tambah')" class="btn-kategori">Tambah Parameter</button>
        </div>

        {{-- FORM: BATAS POIN --}}
        <form method="POST" action="{{ route('pengaturan.update') }}" id="form-batas-poin" class="form-setting hidden">
            @csrf
            <h3 class="font-bold mb-2">Batas Poin</h3>
            @for ($i = 1; $i <= 10; $i++)
                <label>Batas Poin {{ $i }}</label>
                <input type="text" name="parameter[Batas Poin {{ $i }}]" value="{{ $settings['Batas Poin '.$i] ?? '' }}" class="input-setting">
            @endfor
            <button type="submit" class="btn-simpan">Simpan</button>
        </form>

        {{-- FORM: PESAN HADIAH --}}
        <form method="POST" action="{{ route('pengaturan.update') }}" id="form-pesan-poin" class="form-setting hidden">
            @csrf
            <h3 class="font-bold mb-2">Pesan Hadiah</h3>
            @for ($i = 1; $i <= 10; $i++)
                <label>Pesan Batas Poin {{ $i }} Tercapai</label>
                <textarea name="parameter[Pesan Batas Poin {{ $i }} Tercapai]" class="input-setting">{{ $settings['Pesan Batas Poin '.$i.' Tercapai'] ?? '' }}</textarea>
            @endfor
            <label>Pesan Batas Reset Poin</label>
            <textarea name="parameter[Pesan Batas Reset Poin]" class="input-setting">{{ $settings['Pesan Batas Reset Poin'] ?? '' }}</textarea>

            <label>Pesan Notif Poin</label>
            <textarea name="parameter[Pesan Notif Poin]" class="input-setting">{{ $settings['Pesan Notif Poin'] ?? '' }}</textarea>

            <label>Pesan Notif Tukar Poin</label>
            <textarea name="parameter[Pesan Notif Tukar Poin]" class="input-setting">{{ $settings['Pesan Notif Tukar Poin'] ?? '' }}</textarea>

            <label>Pesan Ulang Tahun</label>
            <textarea name="parameter[Pesan Ulang Tahun]" class="input-setting">{{ $settings['Pesan Ulang Tahun'] ?? '' }}</textarea>

            <button type="submit" class="btn-simpan">Simpan</button>
        </form>

        {{-- FORM: PESAN PENGINGAT --}}
        <form method="POST" action="{{ route('pengaturan.update') }}" id="form-pengingat" class="form-setting hidden">
            @csrf
            <h3 class="font-bold mb-2">Pesan Pengingat</h3>
            @for ($i = 1; $i <= 10; $i++)
                <label>Pesan Pengingat {{ $i }}</label>
                <textarea name="parameter[Pesan Pengingat {{ $i }}]" class="input-setting">{{ $settings['Pesan Pengingat '.$i] ?? '' }}</textarea>
            @endfor
            <button type="submit" class="btn-simpan">Simpan</button>
        </form>

        {{-- FORM: HADIAH --}}
        <form method="POST" action="{{ route('pengaturan.update') }}" id="form-hadiah" class="form-setting hidden">
            @csrf
            <h3 class="font-bold mb-2">Hadiah</h3>
            @for ($i = 1; $i <= 6; $i++)
                <label>Hadiah {{ $i }}</label>
                <input type="text" name="parameter[Hadiah {{ $i }}]" value="{{ $settings['Hadiah '.$i] ?? '' }}" class="input-setting">

                <label>Harga Poin Hadiah {{ $i }}</label>
                <input type="number" name="parameter[Harga Poin Hadiah {{ $i }}]" value="{{ $settings['Harga Poin Hadiah '.$i] ?? '' }}" class="input-setting">
            @endfor
            <button type="submit" class="btn-simpan">Simpan</button>
        </form>

        {{-- FORM: LAINNYA --}}
        <form method="POST" action="{{ route('pengaturan.update') }}" id="form-lainnya" class="form-setting hidden">
            @csrf
            <h3 class="font-bold mb-2">Lainnya</h3>
            <label>Batas Hari Pengingat</label>
            <input type="number" name="parameter[Batas Hari Pengingat]" value="{{ $settings['Batas Hari Pengingat'] ?? '' }}" class="input-setting">
            <label>Batas Reset Poin</label>
            <input type="text" name="parameter[Batas Reset Poin]" value="{{ $settings['Batas Reset Poin'] ?? '' }}" class="input-setting">
            <button type="submit" class="btn-simpan">Simpan</button>
        </form>

        {{-- FORM: TAMBAH PARAMETER --}}
        <form method="POST" action="{{ route('pengaturan.update') }}" id="form-tambah" class="form-setting hidden">
            @csrf
            <h3 class="font-bold mb-2">Tambah Parameter Baru</h3>
            <label>Nama Parameter</label>
            <input type="text" name="parameter[NamaBaru]" placeholder="Contoh: Warna Background" class="input-setting">
            <label>Nilai</label>
            <input type="text" name="parameter[NilaiBaru]" class="input-setting">
            <button type="submit" class="btn-simpan">Simpan</button>
        </form>

    </div>
</div>

{{-- JS Tampilkan Form --}}
<script>
    function showForm(id) {
        document.querySelectorAll('.form-setting').forEach(f => f.classList.add('hidden'));
        document.getElementById('form-' + id).classList.remove('hidden');
    }
</script>

{{-- Style ringan --}}
<style>
    .btn-kategori {
        background: #f8b500; color: white; padding: 8px 16px;
        border-radius: 5px; cursor: pointer; font-weight: bold;
    }
    .btn-simpan {
        background: #2563eb; color: white; padding: 8px 20px; margin-top: 10px;
        border-radius: 6px; font-weight: bold;
    }
    .input-setting {
        width: 100%; margin-bottom: 10px; padding: 8px;
        border: 1px solid #ccc; border-radius: 5px;
    }
    .hidden { display: none; }
</style>
</x-app-layout>