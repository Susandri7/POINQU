<x-app-layout>
<x-slot name="header">
<h2 class="text-xl font-bold">Kelola Landing Page</h2>
</x-slot>
<div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white p-6 rounded shadow">

        @if(session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="text-red-600">{{ session('error') }}</div>
        @endif

        <p>Total: {{ $total }} dari {{ $limit }} halaman yang diperbolehkan</p>

        @if($total < $limit)
            <form action="{{ route('landing.store') }}" method="POST" class="mt-3">
                @csrf
                <input type="text" name="slug" placeholder="Slug (contoh: warungbude)" required>
                <input type="text" name="judul" placeholder="Judul Landing Page" required>
                <button type="submit">+ Buat Landing Page</button>
            </form>
        @endif

        <ul class="mt-4 space-y-1">
            @foreach ($pages as $page)
                <li><a href="/{{ $page->slug }}" target="_blank" class="text-blue-600 hover:underline">{{ $page->slug }}</a> – {{ $page->judul }}</li>
            @endforeach
        </ul>

    </div>
</div>
</x-app-layout>