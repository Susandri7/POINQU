<x-app-layout> <x-slot name="header"> <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Data Member </h2> </x-slot>

<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow p-6 rounded">

        {{-- Alert --}}
        @if(session('success'))
            <div style="color:green;">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div style="color:red;">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('member.index') }}" class="mb-4">
            <input type="text" name="cari" placeholder="Cari nama/WA" value="{{ $cari }}" />
            <button type="submit">Cari</button>
        </form>

        <p>Total Member: <strong>{{ $totalMember }}</strong></p>
        <p>Total Poin Keseluruhan: <strong>{{ $totalPoin }}</strong></p>

        <table border="1" cellpadding="8" width="100%" style="margin-top:20px;">
            <thead style="background:#f8b500; color:white;">
                <tr>
                    <th>Nama</th>
                    <th>WA</th>
                    <th>Desa</th>
                    <th>Poin</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->wa }}</td>
                    <td>{{ $member->desa }}</td>
                    <td>{{ $member->poin }}</td>
                    <td>{{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d M Y') }}</td>
                    <td>
                        {{-- Form Tambah Poin --}}
                        <form method="POST" action="{{ route('member.tambah-poin', $member->id) }}" style="display:inline;">
                            @csrf
                            <input type="number" name="jumlah" value="1" min="1" style="width:50px;">
                            <button type="submit">+Poin</button>
                        </form>

                        {{-- Form Tukar Poin --}}
                        <form method="POST" action="{{ route('member.tukar-poin', $member->id) }}" style="display:inline;">
                            @csrf
                            <input type="number" name="jumlah" value="10" min="1" style="width:50px;">
                            <button type="submit">Tukar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $members->withQueryString()->links() }}
        </div>

    </div>
</div>
</x-app-layout>