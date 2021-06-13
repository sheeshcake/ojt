

<li class="sidebar-item @if(isset($dashboard)){{ $dashboard }}@endif">
    <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="sidebar-item  has-sub">
    <a href="#" class='sidebar-link active'>
        <i class="bi bi-stack"></i>
        <span>Menu</span>
    </a>
    <ul class="submenu ">
        <li class="submenu-item @if(isset($subjects)){{ $subjects }}@endif">
            <a href="{{ route('admin.subjects') }}">Subjects</a>
        </li>
        <li class="submenu-item @if(isset($courses)){{ $courses }}@endif">
            <a href="{{ route('admin.courses') }}">Course</a>
        </li>
        <li class="submenu-item @if(isset($departments)){{ $departments }}@endif">
            <a href="{{ route('admin.departments') }}">Departments</a>
        </li>
        <li class="submenu-item @if(isset($prospectus)){{ $prospectus }}@endif">
            <a href="{{ route('admin.prospectus') }}">Prospectus</a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a href="{{ route('admin.logout') }}" class='sidebar-link'>
        <i class="bi bi-door-open-fill"></i>
        <span>Logout</span>
    </a>
</li>