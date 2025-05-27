<!DOCTYPE html> <html lang="id"> <head> <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Daftar Member - {{ $landing->judul ?? 'UMKM' }}</title> <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> <style> body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #f8b500, #fceabb); text-align: center; padding: 20px; } .container { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); } input, select, button { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; } button { background: #f8b500; color: white; font-weight: bold; border: none; cursor: pointer; } button:hover { background: #e09c00; } .form-group { text-align: left; margin-bottom: 10px; } .form-group label { font-weight: bold; display: block; } </style> </head> <body> <h2>Daftar Member {{ $landing->judul ?? '' }}</h2> <p>Isi form di bawah ini untuk menjadi member setia kami dan nikmati berbagai keuntungan!</p>
@if (session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
icon: 'success',
title: 'Pendaftaran Berhasil!',
html: '<b>{{ session('success') }}</b>',
confirmButtonText: 'Oke'
});
</script>
@endif

<div class="container"> <form method="POST" action="{{ route('form.submit') }}"> @csrf

{{-- User ID akan dikirim tersembunyi --}}
  <input type="hidden" name="user_id" value="{{ $user_id }}">

  <div class="form-group">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" required>
  </div>

  <div class="form-group">
    <label for="wa">Nomor WA:</label>
    <input type="text" id="wa" name="wa" required>
  </div>

  <div class="form-group">
    <label for="desa">Desa:</label>
    <input type="text" id="desa" name="desa" required>
  </div>

  <div class="form-group">
    <label>Tanggal Lahir:</label>
    <input type="date" name="tanggal_lahir" required>
  </div>

  <button type="submit">Daftar</button>
</form>
</div> </body> </html>