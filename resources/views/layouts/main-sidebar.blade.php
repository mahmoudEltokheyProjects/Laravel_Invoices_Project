<!-- main-sidebar -->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="{{ url('/' . $page='home') }}"><img src="{{URL::asset('assets/img/brand/logo - Copy.png')}}" class="main-logo" alt="logo"></a>
            <a class="desktop-logo logo-dark active" href="{{ url('/' . $page='home') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='home') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='home') }}"><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
        </div>
        <div class="main-sidemenu">
            <div class="app-sidebar__user clearfix">
                <div class="dropdown user-pro-body">
                    <div class="">
                        <img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/user.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
                    </div>
                    <div class="user-info">
                        <h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
                        <span class="mb-0 text-muted">{{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>
            <ul class="side-menu">
                    <li class="side-item side-item-category">برنامج ادارة الفواتير</li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{ url('/' . $page='home') }}">
                            <i class="fa fa-home fa-lg ml-2" style="color:#5b6e88;"></i>
                            <span class="side-menu__label">الرئيسية</span>
                        </a>
                    </li>
                    @can('قائمة الفواتير')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                            <i class="fa fa-file fa-lg ml-2" style="color:#5b6e88;"></i>
                            <span class="side-menu__label">الفواتير</span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="slide-menu">
                            @can('قائمة الفواتير')
                            <li> <a class="slide-item" href="{{ url('/' . $page='invoices') }}">قائمة الفواتير</a> </li>
                            @endcan
                            @can('الفواتير المدفوعة')
                            <li> <a class="slide-item" href="{{ url('/' . $page='Invoice_Paid') }}">الفواتير المدفوعة</a> </li>
                            @endcan
                            @can('الفواتير الغير مدفوعة')
                            <li> <a class="slide-item" href="{{ url('/' . $page='unpaid_invoice') }}">الفواتير الغير مدفوعة</a> </li>
                            @endcan
                            @can('الفواتير المدفوعة جزئيا')
                            <li> <a class="slide-item" href="{{ url('/' . $page='partial_paid_invoice') }}">الفواتير المدفوعة جزئياً</a> </li>
                            @endcan
                            @can('ارشيف الفواتير')
                            <li> <a class="slide-item" href="{{ url('/' . $page='Archive') }}">ارشيف الفواتير</a> </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('التقارير')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                        <i class="fa fa-print fa-lg ml-2" style="color:#5b6e88;"></i>
                        <span class="side-menu__label">التقارير</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        @can('تقرير الفواتير')
                        <li>
                            <a class="slide-item" href="{{ url('/' . $page='invoices_report') }}">تقارير الفواتير</a>
                        </li>
                        @endcan
                        @can('تقرير العملاء')
                        <li>
                            <a class="slide-item" href="{{ url('/' . $page='customers_report') }}">تقارير العملاء</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('المستخدمين')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                        <i class="fa fa-users fa-lg ml-2" style="color:#5b6e88;"></i>
                        <span class="side-menu__label">المستخدمين</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        @can('قائمة المستخدمين')
                        <li>
                            <a class="slide-item" href="{{ url('/' . $page='users') }}">قائمة المستخدمين</a>
                        </li>
                        @endcan
                        @can('صلاحيات المستخدمين')
                        <li>
                            <a class="slide-item" href="{{ url('/' . $page='roles') }}">صلاحيات المستخدمين</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('الاعدادات')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                        <i class="fa fa-cog fa-lg ml-2" style="color:#5b6e88;"></i>
                        <span class="side-menu__label">الاعدادات</span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        @can('الاقسام')
                        <li> <a class="slide-item" href="{{ url('/' . $page='sections') }}">الاقسام</a> </li>
                        @endcan
                        @can('المنتجات')
                        <li> <a class="slide-item" href="{{ url('/' . $page='products') }}">المنتجات</a> </li>
                        @endcan
                    </ul>
                </li>
                @endcan
            </ul>
        </div>
    </aside>
<!-- main-sidebar -->
