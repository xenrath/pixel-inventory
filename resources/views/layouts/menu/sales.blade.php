<li class="nav-header">Dashboard</li>
<li class="nav-item">
    <a href="{{ url('sales') }}" class="nav-link {{ request()->is('sales') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Menu</li>
<li class="nav-item">
    <a href="{{ url('sales/barang') }}" class="nav-link {{ request()->is('sales/barang*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-boxes"></i>
        <p>
            Data Barang
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('sales/pemasukan') }}" class="nav-link {{ request()->is('sales/pemasukan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>
            Data Pemasukan
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ url('sales/laporan') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-check"></i>
        <p>
            Data Laporan
        </p>
    </a>
</li>
