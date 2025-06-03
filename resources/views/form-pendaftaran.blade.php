<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-yellow-400 via-yellow-200 to-white py-8 px-2">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl px-8 py-10 mt-8 mb-6 relative overflow-hidden border border-yellow-100">
            <div class="flex flex-col items-center mb-6">
                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiYixSNL4CzYvppSv0JizXKrFJ9t_qh-l-ZJV8TIhUb6bK4thtYNXfudZq-9D7ANwF4brfRuIssAISCTkpNBFF3ojXLDho2b8cuMSTCF9s8mZm6hCWhp38ktrlHrKQZG_ZPn_rbLSTpLESsF4gDrAlcy61y4vQ9xb42DaErt2JN-BLm8gK4feDtkgKt/s320/IMG-20250323-WA0000.jpg"
                    alt="Member Ayam Geprek Kremes Abu Ghoffar"
                    class="w-40 h-40 object-cover rounded-xl shadow-lg border-4 border-yellow-300 bg-white">
                <h2 class="text-2xl font-bold text-gray-800 mt-5 mb-1 text-center drop-shadow-lg">Gratis Pendaftaran Member Baru!</h2>
                <p class="text-sm text-gray-600 text-center mb-2">Daftar sebagai <span class="font-semibold text-yellow-600">Member Ayam Geprek Kremes Abu Ghoffar</span> dan nikmati banyak keuntungannya:</p>
            </div>
            <ul class="text-left text-gray-700 mb-6 text-base space-y-2 pl-6 list-disc">
                <li><span class="text-yellow-600 font-bold">Gratis</span> pendaftaran member baru</li>
                <li><span class="text-yellow-600 font-bold">Gratis ongkir</span> saat orderan pertama</li>
                <li><span class="text-yellow-600 font-bold">Gratis 1 porsi</span> saat ulang tahun</li>
                <li><span class="text-yellow-600 font-bold">Gratis ongkir</span> setiap 10 poin</li>
                <li><span class="text-yellow-600 font-bold">Gratis teh es</span> setiap 15 poin</li>
                <li><span class="text-yellow-600 font-bold">Gratis 1 porsi</span> setiap 20 poin</li>
                <li><span class="text-yellow-600 font-bold">Dan promo menarik lainnya</span></li>
            </ul>
            <form id="form-daftar" method="POST" action="{{ route('form.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nama" class="block font-semibold text-gray-700 mb-1">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                        class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                    @error('nama')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="wa" class="block font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" id="wa" name="wa" value="{{ old('wa') }}" required
                        class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                    @error('wa')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="desa" class="block font-semibold text-gray-700 mb-1">Desa</label>
                    <input type="text" id="desa" name="desa" value="{{ old('desa') }}" required
                        class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                    @error('desa')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="block font-semibold text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                        class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                    @error('tanggal_lahir')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" id="btn-daftar"
                    class="w-full py-3 bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-lg shadow transition duration-150 ease-in-out text-lg tracking-wide flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Daftar Sekarang
                </button>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Loading SweetAlert2 saat submit
        document.getElementById('form-daftar').addEventListener('submit', function(e) {
            Swal.fire({
                title: 'Memproses...',
                text: 'Silakan tunggu, pendaftaran sedang diproses.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });

        // Jika ada error pada WA (dari backend/validasi)
        @error('wa')
        Swal.fire({
            icon: 'error',
            title: 'Pendaftaran Gagal',
            html: `<b>{{ $message }}</b>`,
            confirmButtonText: 'Oke'
        });
        @enderror

        // Pendaftaran berhasil (dari session sukses)
        @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Pendaftaran Berhasil!',
            html: '<b>{{ session('success') }}</b>',
            confirmButtonText: 'Oke'
        });
        @endif
    </script>
</x-app-layout>