<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>

    @can('admin')
        <li class="nav-header">MANAJEMEN KONTEN</li>

        <li class="nav-item">
            <a href="{{ route('fiturs.index') }}" class="nav-link {{ request()->is('fiturs*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-star"></i>
                <p>Manajemen Fitur</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('pakets.index') }}" class="nav-link {{ request()->is('pakets*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-box-open"></i>
                <p>Manajemen Paket</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.transaksis.index') }}"
                class="nav-link {{ request()->is('admin/transaksis*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>Manajemen Transaksi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.services.index') }}"
                class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-concierge-bell"></i>
                <p>Edit Deskripsi Layanan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.about.index') }}"
                class="nav-link {{ request()->is('admin/about*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-info-circle"></i>
                <p>Edit About Us</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('galleries.index') }}" class="nav-link {{ request()->is('galleries*') ? 'active' : '' }}">
                <i class="nav-icon far fa-image"></i>
                <p>Manajemen Galeri</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>Manajemen Pengguna</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.messages.index') }}"
                class="nav-link {{ request()->is('admin/messages*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-envelope"></i>
                <p>Pesan Masuk</p>
            </a>
        </li>
    @endcan
    {{-- <li class="nav-header">AKUN</li>

    <li class="nav-item">
        <a href="{{ route('profile.edit') }}"
            class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>Profil</p>
        </a>
    </li> --}}

</ul>
