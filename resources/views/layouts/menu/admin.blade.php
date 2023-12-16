<li class="nav-header">Dashboard</li>
<li class="nav-item">
    <a href="{{ url('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Menu</li>
<li class="nav-item">
    <a href="{{ url('admin/barang') }}" class="nav-link {{ request()->is('admin/barang*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-boxes"></i>
        <p>
            Data Barang
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/pemasukan') }}" class="nav-link {{ request()->is('admin/pemasukan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shipping-fast"></i>
        <p>
            Data Pemasukan
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/pengeluaran') }}" class="nav-link {{ request()->is('admin/pengeluaran*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-check"></i>
        <p>
            Data Pengeluaran
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('admin/laporan') }}" class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
            Data Laporan
        </p>
    </a>
</li>
