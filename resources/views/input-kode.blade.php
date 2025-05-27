<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
Input Kode Member
</h2>
</x-slot>
<div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow p-6 rounded">
        {{-- Konten kamu sebelumnya --}}

        <div class="container text-center">
            <h2 style="background: linear-gradient(135deg, #f8b500, #e09c00); padding: 10px; border-radius: 8px;">
                INPUT KODE MEMBER <br> Ayam Geprek Kremes Abu Ghoffar
            </h2>

            <div class="my-4">
                <input type="text" id="kodeUnik" placeholder="Masukkan Kode Member" maxlength="4">
                <button onclick="cekKode()">Cek Kode</button>
            </div>

            <div id="hasilCek" style="display:none;"></div>

            <div class="my-4" id="tambahPoinArea" style="display:none;">
                <input type="number" id="customPoin" value="1" min="1" style="width: 60px;">
                <button onclick="tambahPoin()">➕ Tambah Poin</button>
            </div>

            <div class="my-4" id="notifWA" style="display:none;"></div>

            <div id="tukarPoinArea" style="display:none;">
                <select id="pilihanHadiah">
                    <option value="">Memuat daftar hadiah...</option>
                </select>
                <button onclick="tukarPoin()">🔁 Tukar Poin</button>
            </div>

            <div id="pesanPoin"></div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let member = {};

            function cekKode() {
    let kode = document.getElementById("kodeUnik").value;
    if (!kode) return alert("Masukkan kode!");

    fetch("/api/cek-kode/" + kode)
        .then(res => {
            if (!res.ok) throw new Error("Server error / kode tidak ditemukan");
            return res.json();
        })
        .then(data => {
            if (!data.success) return Swal.fire("Gagal", "Kode tidak ditemukan", "error");

            member = data.member;
            document.getElementById("hasilCek").innerHTML = `<b>${member.nama}</b><br>Poin: ${member.poin}`;
            document.getElementById("hasilCek").style.display = "block";
            document.getElementById("tambahPoinArea").style.display = "block";
            document.getElementById("tukarPoinArea").style.display = "block";
        })
        .catch(err => {
            Swal.fire("Gagal", err.message, "error");
        });
}

            function tambahPoin() {
                let jumlah = parseInt(document.getElementById("customPoin").value);
                fetch("/api/tambah-poin", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        kode: member.kode_unik,
                        poin: jumlah
                    })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire("Berhasil", data.message, "success");
                    document.getElementById("pesanPoin").innerHTML = `<p>Poin sekarang: ${data.poin}</p>`;
                    document.getElementById("notifWA").innerHTML = `<a target="_blank" href="${data.link_wa}">📩 Kirim Notif WA</a>`;
                    document.getElementById("notifWA").style.display = "block";
                });
            }

            function tukarPoin() {
    let hadiah_id = document.getElementById("pilihanHadiah").value;
    if (!hadiah_id) return alert("Pilih hadiah terlebih dahulu");

    fetch("/api/tukar-poin", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            kode: member.kode_unik,
            hadiah_id: hadiah_id
        })
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) return Swal.fire("Gagal", data.message, "error");
        Swal.fire("Berhasil", "Poin berhasil ditukar!", "success");

        document.getElementById("pesanPoin").innerHTML = `<p>${data.message}</p>`;
        document.getElementById("notifWA").innerHTML = `<a target="_blank" href="${data.link_wa}">📩 Kirim Notif WA</a>`;
        document.getElementById("notifWA").style.display = "block";
    });
}
        </script>
    </div>
</div>
</x-app-layout>