    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="/" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ URL::asset('assets/images/logo_MAA.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ URL::asset('assets/images/logo_MAAA.png') }}" alt="" height="35">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="/" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ URL::asset('assets/images/logo_MAA.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ URL::asset('assets/images/logo_MAAA.png') }}" alt="" height="35">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        <div id="scrollbar">
            <div class="container-fluid">

                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>@lang('translation.menu')</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('root') }}" aria-controls="sidebarDashboards">
                            <i class="ri-dashboard-2-line"></i> <span>@lang('translation.dashboards')</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('employees') }}">
                            <i class="ri-honour-line"></i> <span>Employee</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('company-regulation') }}">
                            <i class="ri-dashboard-2-line"></i> <span>Company Regulation</span>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('it-helpdesk') }}">
                            <i class="ri-dashboard-2-line"></i> <span>IT Helpdesk</span>
                        </a>
                    </li>



                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarApps">
                            <i class="ri-apps-2-line"></i> <span>Policy,SOP & Form</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarApps">
                            <ul class="nav nav-sm flex-column">
                                <li>
                                </li>
                                <li class="nav-item">
                                    <a href="apps-calendar" class="nav-link">Policy</a>
                                </li>
                                <li class="nav-item">
                                    <a href="apps-chat" class="nav-link">SOP & Form</a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}

                    @if (session('user')->divisi === 'HRGA')
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#project" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="project">
                                <i class="ri-apps-2-line"></i> <span>Project & Task</span>
                            </a>
                            <div class="collapse menu-dropdown" id="project">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('projects.show') }}" class="nav-link">Project List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('tasks.index') }}" class="nav-link">Task List</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
