<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{url('sica/dashboard')}}" class="app-brand-link">
              <span class="app-brand-logo demo">
				<img class="main-logo" src="{{ asset('sica/assets/img/logo.png')}}">
			  </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('sica/dashboard') ? 'active' : '' }}">
            <a href="{{url('sica/dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <!-- Tables -->
        <li class="menu-item {{ request()->is('sica/school-data') || request()->is('sica/school-images*') ? 'active' : '' }}">
            <a href="{{url('sica/school-data')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">School Data</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{url('sica/logout')}}" class="menu-link">
                <i class="bx bx-power-off me-2"></i>
                <span data-i18n="Basic">Logout</span>
            </a>
        </li>
    </ul>
</aside>
