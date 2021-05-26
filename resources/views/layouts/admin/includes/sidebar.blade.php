<div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link {{ session()->get('dashboard') }}" href="{{ route('admin.dashboard') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-tachometer blackiconcolor" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ session()->get('subjects') }}" href="{{ route('admin.subjects') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-book blackiconcolor" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Subjects</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ session()->get('dashboard') }}" href="{{ url('/') }}/pages/billing.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-star blackiconcolor" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Course</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('/') }}/pages/rtl.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-building blackiconcolor" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Departments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ url('/') }}/pages/rtl.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-building blackiconcolor" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Prospectus</span>
            </a>
        </li>
    </ul>
</div>