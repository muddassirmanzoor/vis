<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{url('assessment')}}" class="app-brand-link">
				<span class="app-brand-logo demo">
                    <img src="{{ asset('img/PMIU-Full-Logo.png')}}"  style="width: 216px;">
                </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Layouts -->

        <!-- Forms & Tables -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Quran Assessment form</span></li>
        <!-- Tables -->

        <li class="menu-item">
            <a href="{{url('assessment')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Layouts">Assessment form</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{url('show-assessment')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Data Entered</div>
            </a>
        </li>
    </ul>
</aside>
