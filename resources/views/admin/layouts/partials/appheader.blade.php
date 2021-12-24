<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">

                <a href="{{ url('admin/dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/dashlogo.png') }}" alt="" height="35">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect vertical-menu-btn">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="d-none d-sm-block">
                <!-- App Search-->
                <div class="app-search d-none d-lg-block">
                    <div class="position-relative" style="width:300px;">
                        <input type="text" class="form-control" id="desksearchbox" placeholder="이름/전화번호">
                        <span id="btn_desksearch" class="fa fa-search"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">
                    <div class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" id="mobilesearchbox" class="form-control" placeholder="이름/전화번호" aria-label="이름/전화번호">
                                <div class="input-group-append">
                                    <a href="javascript:void(0);" id="btn_mobilesearch" class="btn btn-primary"><i class="mdi mdi-magnify"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen font-size-24"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti-bell"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0"> Notifications (258) </h5>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="javascript:void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                    <span class="avatar-title border-success rounded-circle ">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </span>
                                </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your order is placed</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">If several languages coalesce the grammar</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="javascript:void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                    <span class="avatar-title border-warning rounded-circle ">
                                        <i class="mdi mdi-message"></i>
                                    </span>
                                </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New Message received</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">You have 87 unread messages</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="javascript:void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                    <span class="avatar-title border-info rounded-circle ">
                                        <i class="mdi mdi-glass-cocktail"></i>
                                    </span>
                                </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your item is shipped</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">It is a long established fact that a reader will</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="javascript:void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                    <span class="avatar-title border-primary rounded-circle ">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </span>
                                </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Your order is placed</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">Dummy text of the printing and typesetting industry.</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="javascript:void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-xs">
                                    <span class="avatar-title border-warning rounded-circle ">
                                        <i class="mdi mdi-message"></i>
                                    </span>
                                </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New Message received</h6>
                                    <div class="text-muted">
                                        <p class="mb-1">You have 87 unread messages</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-link font-size-14 w-100 text-center" href="javascript:void(0)">
                            View all
                        </a>
                    </div>
                </div>
            </div>
            

            <div class="dropdown d-inline-block pt-1 mt-1">
                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/user-4.jpg') }}"
                    alt="Header Avatar">
                    <?php $user = Auth::guard('admin')->user(); ?>
                    {{ $user ? $user->name : "N/A" }}
                    <i class="mdi mdi-chevron-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-user-dropdown">
                    <!-- item-->
                    <!--a class="dropdown-item" href="#">
                        <i class="mdi mdi-account-circle font-size-17 text-muted align-middle me-1"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-wallet font-size-17 text-muted align-middle me-1"></i> My Wallet
                    </a>
                    <a class="dropdown-item d-block" href="#">
                        <span class="badge bg-success float-end">11</span>
                        <i class="mdi mdi-cog font-size-17 text-muted align-middle me-1"></i> Settings
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-lock-open-outline font-size-17 text-muted align-middle me-1"></i> Lock screen
                    </a>
                    <div class="dropdown-divider"></div-->
                    <a class="dropdown-item text-danger" href="{{ url('admin/logout')}}">
                        <i class="mdi mdi-power font-size-17 text-muted align-middle me-1 text-danger"></i> Logout
                    </a>
                </div>
            </div>
            
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-wechat" style="font-size:35px;"></i>
                    @if($adminmemos_count != 0)
                    <span class="badge bg-danger rounded-pill">{{$adminmemos_count}}</span>
                    @endif
                    
                </button>
            </div>

         
        </div>
    </div>
</header>
