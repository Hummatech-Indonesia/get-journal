<div id="kt_aside" class="aside overflow-visible pb-5 pt-5 pt-lg-0" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'80px', '300px': '100px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo py-8" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ url('/') }}" class="d-flex align-items-center">
            <img alt="Logo" src="{{asset('assets/logo/logo.png')}}" class="h-45px logo" />
        </a>
        <!--end::Logo-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid" id="kt_aside_menu">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-y my-2 my-lg-5 scroll-ms" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold" id="#kt_aside_menu" data-kt-menu="true">
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{request()->routeIs('dashboard') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <a href="{{ route('dashboard') }}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-element-11 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{request()->routeIs('teacher.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <a href="{{route('teacher.index')}}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-teacher fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Guru</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{request()->routeIs('class.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <a href="{{route('classes.index')}}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-book-open fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Kelas</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2  {{request()->routeIs('student.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <a href="{{route('student.index')}}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-briefcase fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <span class="menu-title">Siswa</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{request()->routeIs('transactions.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <a href="{{route('transactions.index')}}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-chart-simple-2 fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Transaksi</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item py-2 {{request()->routeIs('premium.*') ? 'here show' : ''}}">
                    <!--begin:Menu link-->
                    <a href="{{route('premium.index')}}" class="menu-link menu-center">
                        <span class="menu-icon me-0">
                            <i class="ki-duotone ki-medal-star fs-2x">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                        </span>
                        <span class="menu-title">Premium</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
</div>