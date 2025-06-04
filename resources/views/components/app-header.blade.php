<div class="bg-white rounded-xl shadow-lg p-6 mb-6 mx-auto max-w-7xl">
    <div class="flex flex-col sm:flex-row items-center gap-4">
        <div class="flex items-center gap-4 w-full">
            <div class="w-28 h-28 rounded-full bg-blue-400 flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-md">
                {{ strtoupper(Str::substr(Auth::user()->name ?? 'U', 0, 2)) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-semibold text-gray-900">{{ Auth::user()->name ?? 'User' }}</span>
                    @if(Auth::user()->email_verified_at)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586l-3.293-3.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                    @endif
                </div>
                <div class="mt-2">
                    <span class="inline-block bg-green-500 text-white text-xs rounded-full px-3 py-1">Verified</span>
                </div>
            </div>
        </div>

        <div class="ml-auto">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <button @click="open = !open" type="button"
                    class="inline-flex items-center px-4 py-2 border border-blue-400 text-blue-600 bg-white rounded-lg hover:bg-blue-50 transition-colors max-w-[200px]"
                    id="admin-menu-button" aria-expanded="true" aria-haspopup="true"
                    style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <span class="truncate max-w-[110px] inline-block align-middle" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ Auth::user()->name }}
                    </span>
                    <svg class="w-4 h-4 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 z-10 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                    x-transition>
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pengingat Aktivasi Member Baru --}}
    @if(!empty($pendingMembers) && count($pendingMembers) > 0)
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-6 rounded flex items-center gap-2">
        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/></svg>
        <span>
            <strong>{{ count($pendingMembers) }}</strong> member baru menunggu aktivasi!
        </span>
        <a href="{{ route('aktivasi') }}" class="ml-2 inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">Cek Sekarang</a>
    </div>
    @endif

    {{-- Alert --}}
    @if(session('status'))
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-6 flex items-center gap-2 rounded">
        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/></svg>
        <span>{{ session('status') }}</span>
    </div>
    @endif
</div>



<div class="container mx-auto">
    @if(Auth::user() && Auth::user()->status_aktif == false && Auth::user()->email !== 'admin@poinqu.my.id')
        @php
            $expired = Auth::user()->aktif_sampai && now()->greaterThan(Auth::user()->aktif_sampai);
        @endphp

        @if($expired)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl">
                <strong>Akun Anda expired.</strong><br>
                Silakan hubungi admin untuk memperpanjang masa aktif akun Anda.
            </div>
        @else
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-xl">
                <strong>Akun Anda belum diaktivasi.</strong><br>
                Silakan hubungi admin untuk melanjutkan proses aktivasi akun.
            </div>
        @endif
    @endif

    @if(Auth::user() && Auth::user()->status_aktif == true && Auth::user()->email !== 'admin@poinqu.my.id')
        @php
            $aktifSampai = Auth::user()->aktif_sampai ? \Carbon\Carbon::parse(Auth::user()->aktif_sampai) : null;
            $now = now();
            $diffInDays = $aktifSampai ? $now->diffInDays($aktifSampai, false) : null;
            $diffInHours = $aktifSampai ? $now->diffInHours($aktifSampai, false) : null;
            $isWarning = $aktifSampai && $diffInDays <= 90 && $diffInDays >= 0;
        @endphp

        @if($isWarning)
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-xl">
                <strong>
                    @if($diffInDays > 1)
                        Akun Anda expired {{ $diffInDays }} hari lagi.
                    @elseif($diffInDays == 1)
                        Akun Anda expired 24 jam lagi.
                    @elseif($diffInDays == 0 && $diffInHours > 1)
                        Akun Anda expired {{ $diffInHours }} jam lagi.
                    @elseif($diffInDays == 0 && $diffInHours == 1)
                        Akun Anda expired 1 jam lagi.
                    @endif
                </strong>
                <br>
                Silakan hubungi admin untuk memperpanjang masa aktif akun Anda.
            </div>
        @endif

        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-xl">
            <strong>Akun Anda sudah Aktif.</strong> <br>
            <strong>Tanggal Aktivasi: </strong>
            @if(Auth::user()->aktif_mulai && Auth::user()->aktif_sampai)
                {{ \Carbon\Carbon::parse(Auth::user()->aktif_mulai)->format('d M Y - H:i') }}
                <br>
                <strong>Masa aktif sd: </strong>
                {{ \Carbon\Carbon::parse(Auth::user()->aktif_sampai)->format('d M Y - H:i') }}
            @else
                Tidak terbatas
            @endif
        </div>
    @endif
</div>