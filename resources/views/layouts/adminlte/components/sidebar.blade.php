<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <!--end::Brand Text-->
            <span class="brand-text fw-light">{{ config('app.name') ?? 'Laravel' }}</span>
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('courses')}}" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('materials')}}" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Materials</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('assignments')}}" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Assignment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('submissions')}}" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Submission</p>
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <button class="nav-link">
                                <i class="nav-icon bi bi-arrow-right"></i>
                                <p>{{Auth::user()->name}} | Logout</p>
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
