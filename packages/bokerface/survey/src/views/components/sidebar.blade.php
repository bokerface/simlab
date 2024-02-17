<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">Survey</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ Request::is('survey/daftar-survey')?'active':'' }}">
        <a class="nav-link" href="{{ url('survey') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
</ul>