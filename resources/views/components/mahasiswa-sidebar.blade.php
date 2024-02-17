<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        {{-- <div class="sidebar-brand-icon">
            <img src="img/logo/logo2.png">
        </div> --}}
        <div class="sidebar-brand-text mx-3">SIM Praktikum</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{Request::is('/')?'active':''}}">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Praktikum
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed active" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
            aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Praktikum</span>
        </a>
        <div id="collapseBootstrap"
            class="collapse {{Request::is('jadwal-praktikum')?'show':''}} {{Request::is('semua-praktikum')?'show':''}} {{Request::is('arsip-praktikum')?'show':''}} {{Request::is('jadwal-kuliah-lapangan')?'show':''}} {{Request::is('jadwal-kuliah-umum')?'show':''}}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('jadwal-praktikum')?'active':''}}"
                    href="{{ url('/jadwal-praktikum') }}">
                    Jadwal Praktikum
                </a>
                <a class="collapse-item {{Request::is('semua-praktikum')?'active':''}}"
                    href="{{ url('/semua-praktikum') }}">
                    Semua Praktikum
                </a>
                <a class="collapse-item {{Request::is('arsip-praktikum')?'active':''}}"
                    href="{{ url('/arsip-praktikum') }}">
                    Arsip Praktikum
                </a>
                <a class="collapse-item {{Request::is('jadwal-kuliah-umum')?'active':''}}"
                    href="{{ url('/jadwal-kuliah-umum') }}">
                    Kuliah Umum
                </a>
                <a class="collapse-item {{Request::is('jadwal-kuliah-lapangan')?'active':''}}"
                    href="{{ url('/jadwal-kuliah-lapangan') }}">
                    Kuliah Lapangan
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Softskill
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed active" href="#" data-toggle="collapse" data-target="#softskill_menu"
            aria-expanded="true" aria-controls="softskill_menu">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Softskill</span>
        </a>
        <div id="softskill_menu"
            class="collapse {{Request::is('jadwal-softskill')?'show':''}} {{Request::is('arsip-softskill')?'show':''}} {{Request::is('mahasiswa')?'show':''}}"
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{Request::is('jadwal-softskill')?'active':''}}"
                    href="{{ url('/jadwal-softskill') }}">
                    Jadwal Softskill
                </a>
                <a class="collapse-item {{Request::is('arsip-softskill')?'active':''}}"
                    href="{{ url('/arsip-softskill') }}">
                    Arsip Softskill
                </a>
            </div>
        </div>
    </li>
</ul>