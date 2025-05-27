<x-app-layout> <x-slot name="header"> <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Halaman Aktivasi User UMKM </h2> </x-slot>

<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    @if (session('success'))
        <div style="background-color:#dff0d8; padding:10px; margin-bottom:15px; border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    @if (count($users) === 0)
        <p>Tidak ada user yang menunggu aktivasi.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" style="width:100%; background:#fff;">
            <thead>
                <tr style="background:#f8b500; color:white;">
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Daftar Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <form action="{{ route('aktivasi.proses', $user->id) }}" method="POST" onsubmit="return confirm('Aktifkan user ini?')">
                            @csrf
                            <button type="submit" style="background:#28a745; color:white; padding:5px 10px; border:none; border-radius:5px;">Aktifkan</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-app-layout>