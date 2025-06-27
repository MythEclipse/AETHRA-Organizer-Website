<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>

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

    <li class="nav-header">AKUN</li>

    <li class="nav-item">
        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>Profil</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.transaksis.index') }}"
            class="nav-link {{ request()->is('admin/transaksis*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p>Manajemen Transaksi</p>
        </a>
    </li>
</ul>
