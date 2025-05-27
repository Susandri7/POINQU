<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #f8b500, #fceabb); text-align: center; padding: 20px; }
        .container { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); }
        input, select, button { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #f8b500; color: white; font-weight: bold; border: none; cursor: pointer; }
        button:hover { background: #e09c00; }
        .form-group { text-align: left; margin-bottom: 10px; }
        .form-group label { font-weight: bold; display: block; }
        .date-container { display: flex; gap: 5px; justify-content: space-between; }
        .select-wrapper { flex: 1; }
        .alert-danger { color: #b94a48; background: #f2dede; border: 1px solid #eed3d7; padding: 8px; border-radius: 5px; margin-bottom: 5px;}
    </style>
</head>
<body>
    <h2>Gratis Pendaftaran Member Baru!</h2>
    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiYixSNL4CzYvppSv0JizXKrFJ9t_qh-l-ZJV8TIhUb6bK4thtYNXfudZq-9D7ANwF4brfRuIssAISCTkpNBFF3ojXLDho2b8cuMSTCF9s8mZm6hCWhp38ktrlHrKQZG_ZPn_rbLSTpLESsF4gDrAlcy61y4vQ9xb42DaErt2JN-BLm8gK4feDtkgKt/s320/IMG-20250323-WA0000.jpg"
         style="width:270px; border-radius:10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); margin-top:10px;">
    <br><br>
    <p>Daftar sebagai <strong>Member Ayam Geprek Kremes Abu Ghoffar</strong> dan nikmati banyak keuntungannya:</p>
    <ul style="text-align:left; font-size:15px;">
    
        <li>👉 Gratis pendaftaran member baru</li>
        <li>👉 Gratis ongkir saat orderan pertama</li>
        <li>👉 Gratis 1 porsi saat ulang tahun</li>
        <li>👉 Gratis ongkir setiap 10 poin</li>
        <li>👉 Gratis teh es setiap 15 poin</li>
        <li>👉 Gratis 1 porsi setiap 20 poin</li>
        <li>👉 Dan promo menarik lainnya</li>
    </ul>

    <div class="container">
        <form id="form-daftar" method="POST" action="{{ route('form.submit') }}">
            @csrf

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="wa">Nomor WA:</label>
                <input type="text" id="wa" name="wa" value="{{ old('wa') }}" required>
                @error('wa')
                  <div class="alert alert-danger d-none" id="wa-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="desa">Desa:</label>
                <input type="text" id="desa" name="desa" value="{{ old('desa') }}" required>
                @error('desa')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                @error('tanggal_lahir')
                  <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" id="btn-daftar">Daftar</button>
        </form>
    </div>

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
</body>
</html>