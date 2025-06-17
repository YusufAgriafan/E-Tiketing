<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">Dashboard</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <x-sidebar-link href="{{ route('dashboard') }}" icon="fa-tachometer-alt" :active="request()->is('dashboard')">Dashboard</x-sidebar-link>
    <x-sidebar-link href="{{ route('dashboard.kuota') }}" icon="fa-table" :active="request()->is('dashboard/kuota')">Kuota</x-sidebar-link>
    <x-sidebar-link href="{{ route('dashboard.jaket') }}" icon="fas fa-tshirt" :active="request()->is('dashboard/jaket')">Jersey</x-sidebar-link>
    <x-sidebar-link href="{{ route('dashboard.tiket') }}" icon="fas fa-ticket-alt" :active="request()->is('dashboard/tiket')">Tiket</x-sidebar-link>
    <x-sidebar-link href="{{ route('dashboard.bukti-bayar') }}" icon="fas fa-file-image" :active="request()->is('dashboard/bukti-bayar')">Bukti
        Pembayaran</x-sidebar-link>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <x-sidebar-label>Scan</x-sidebar-label>

    <x-sidebar-link href="{{ route('dashboard.scanner1') }}" icon="fa-camera" :active="request()->is('dashboard/scanner/1')">Scanner
        Jersey</x-sidebar-link>
    <x-sidebar-link href="{{ route('dashboard.scanner2') }}" icon="fa-camera" :active="request()->is('dashboard/scanner/2')">Scanner
        Tiket</x-sidebar-link>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <x-sidebar-link href="{{ route('dashboard.export') }}" icon="fa-download" :active="request()->is('dashboard/scanner/2')">Export
        Excel</x-sidebar-link>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-sidebar-link href="#" icon="fa-sign-out-alt"
            onclick="event.preventDefault(); this.closest('form').submit();">
            Logout
        </x-sidebar-link>
    </form>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

