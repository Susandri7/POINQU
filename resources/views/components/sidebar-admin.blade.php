<div x-data="{ open: false }" class="md:block">
    <!-- Hamburger on mobile -->
    <button @click="open = !open" class="md:hidden flex items-center px-4 py-2 text-white bg-black rounded mb-2">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <span class="ml-2">Menu</span>
    </button>
    <nav :class="{'block': open, 'hidden': !open}" class="md:block bg-black rounded-xl py-4 px-0 flex flex-col gap-1 shadow-md">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->routeIs('dashboard') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/></svg>
            Dashboard
        </a>
        <a href="{{ route('aktivasi') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('aktivasi') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM7.16 10.66l.84-.84V4a2 2 0 012-2h6a2 2 0 012 2v5.82l.84.84A3.97 3.97 0 0120 14.5c0 2.21-1.79 4-4 4H8c-2.21 0-4-1.79-4-4 0-1.1.45-2.1 1.16-2.84z"/></svg>
            Aktivasi UMKM
        </a>
        <a href="{{ route('backup.download') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('backup') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            Backup Data
        </a>
        <a href="{{ url('/admin/member') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('admin/member') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            Data Member
        </a>
        <a href="{{ url('/admin/settings') }}" class="flex items-center gap-2 px-6 py-3 rounded-full {{ request()->is('admin/settings') ? 'bg-white text-black font-semibold shadow-inner' : 'hover:bg-gray-800 text-white' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h10a2 2 0 002-2v-7a2 2 0 00-2-2zm-2 6a2 2 0 01-4 0"/></svg>
            Pengaturan Landing Page
        </a>
    </nav>
</div>