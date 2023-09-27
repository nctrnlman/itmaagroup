    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="/" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?php echo e(URL::asset('assets/images/logo_MAA.png')); ?>" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?php echo e(URL::asset('assets/images/logo_MAAA.png')); ?>" alt="" height="35">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="/" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?php echo e(URL::asset('assets/images/logo_MAA.png')); ?>" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?php echo e(URL::asset('assets/images/logo_MAAA.png')); ?>" alt="" height="35">
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
                    <li class="menu-title"><span><?php echo app('translator')->get('translation.menu'); ?></span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="<?php echo e(route('root')); ?>" aria-controls="sidebarDashboards">
                            <i class="ri-dashboard-2-line"></i> <span><?php echo app('translator')->get('translation.dashboards'); ?></span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="<?php echo e(route('it-helpdesk')); ?>">
                            <i class="ri-pencil-ruler-2-line"></i> <span>IT Support</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#ga" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="ga">
                            <i class="ri-file-list-3-line"></i> <span>GA Facilities</span>
                        </a>
                        <div class="collapse menu-dropdown" id="ga">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('stationary-facilities.index')); ?>" class="nav-link">ATK /
                                        Stationary</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('building-facilities.index')); ?>" class="nav-link">Building
                                        Maintenance Support</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('other-facilities.index')); ?>" class="nav-link">Other Facilities
                                        Request</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    

                    <?php if(session('user')->divisi === 'HRGA' || session('user')->access_type === 'Admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#project" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="project">
                                <i class="ri-apps-2-line"></i> <span>Project & Task</span>
                            </a>
                            <div class="collapse menu-dropdown" id="project">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('projects.show')); ?>" class="nav-link">Project List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('tasks.index')); ?>" class="nav-link">Task List</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>





                </ul>
                <?php if(session('user')['access_type'] === 'Admin'): ?>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span>Admin Access</span></li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo e(route('admin.dashboard')); ?>">
                                <i class="ri-honour-line"></i> <span>Administrator</span>
                            </a>
                        </li>


                    </ul>
                <?php endif; ?>
                <?php if(session('user')['access_type'] === 'Admin' || session('user')['access_type'] === 'GA Stationary'): ?>
                    <ul class="navbar-nav" id="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo e(route('atk.index')); ?>">
                                <i class="ri-scissors-line"></i> <span>ATK List</span>
                            </a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
<?php /**PATH C:\it\ticket\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>