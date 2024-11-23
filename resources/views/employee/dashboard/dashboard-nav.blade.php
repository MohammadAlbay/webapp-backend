<nav class="sidebar sidebar-offcanvas" id="sidebar" style="margin:0px; padding-right:0px; padding-left:0px">
  <ul class="nav" style="padding:5px">
    <li class="nav-item nav-category">لوحة التحكم </li>
    <li class="nav-item">
      <a class="nav-link" href="homepage">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-cube menu-icon"></i></span>
        <span class="menu-title">الرئيسية</span>
      </a>
    </li>
    <!--  :::: Employee menu -->
    @if(!$me->hasPermission(\App\Models\Permission::PERMISSION_ADD_EMPLOYEE_NAME)
    &&  !$me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_EMPLOYEE_NAME))
    @else
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-contacts menu-icon"></i></span>
        <span class="menu-title">الموظفين</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          @if($me->hasPermission(\App\Models\Permission::PERMISSION_ADD_EMPLOYEE_NAME))
          <li class="nav-item" style="margin:5px;"> <a class="nav-link" href="add-employee" style="">اضافة موظف</a></li>
          @endif
          @if($me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_EMPLOYEE_NAME))
          <li class="nav-item" style="margin:5px"> <a class="nav-link" href="employee-list">قائمة الموظفين</a></li>
          @endif
        </ul>
      </div>
    </li>
    @endif
    <!--  :::: Manage Specializations menu -->
    @if($me->role()->name == 'Admin')
    <li class="nav-item">
      <a class="nav-link" href="specializations-list">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-cube menu-icon"></i></span>
        <span class="menu-title">ادارة التخصصات</span>
      </a>
    </li>
    @endif
    <!--  :::: Role & permissions menu -->
    @if($me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_PERMISSION_NAME))
    <li class="nav-item">
      <a class="nav-link" href="permission-list">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-cube menu-icon"></i></span>
        <span class="menu-title">ادارة الصلاحيات</span>
      </a>
    </li>
    @endif
    @if($me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_ROLE_NAME))
    <li class="nav-item">
      <a class="nav-link" href="role-list">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-cube menu-icon"></i></span>
        <span class="menu-title">ادارة المسميات الوظيفية</span>
      </a>
    </li>
    @endif
    <!--  :::: Prepaid cards & permissions menu -->
    @if(!$me->hasPermission(\App\Models\Permission::PERMISSION_GENERATE_PREPAIDCARDS_NAME)
    &&  !$me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_PREPAIDCARDS_NAME))
    @else
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#cards-menulist" aria-expanded="false" aria-controls="cards-menulist">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-format-list-bulleted menu-icon"></i></span>
        <span class="menu-title">بطاقة الشحن</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="cards-menulist">
        <ul class="nav flex-column sub-menu">
          @if($me->hasPermission(\App\Models\Permission::PERMISSION_GENERATE_PREPAIDCARDS_NAME))
          <li class="nav-item" style="margin:0px"> <a class="nav-link" href="generate-cards">توليد بطاقات دفع</a></li>
          @endif
          @if($me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_PREPAIDCARDS_NAME))
          <li class="nav-item" style="margin:0px"> <a class="nav-link" href="prepaidcards-list">بطاقات الدفع المسجلة</a></li>
          @endif
          <!-- <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li> -->
        </ul>
      </div>
    </li>
    @endif
    <!--  :::: Customers -->
    @if($me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_CUSTOMER_NAME))
    <li class="nav-item">
      <a class="nav-link" href="manage-customers">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-contacts menu-icon"></i></span>
        <span class="menu-title">الزبائن</span>
      </a>
    </li>
    @endif
    <!--  :::: Technicains -->
    @if($me->hasPermission(\App\Models\Permission::PERMISSION_TECHNICAIN_VIEW_NAME))
    <li class="nav-item">
      <a class="nav-link" href="manage-technicain">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-contacts menu-icon"></i></span>
        <span class="menu-title">الفنيين</span>
      <a>
    </li>
    @endif
    <!--  :::: Reports -->
    @if(!$me->hasPermission(\App\Models\Permission::PERMISSION_CUSTOMER_REPORTS_NAME)
    &&  !$me->hasPermission(\App\Models\Permission::PERMISSION_TECHNICAIN_REPORTS_NAME))
    @else
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#cards-menulistaa" aria-expanded="false" aria-controls="cards-menulistaa">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-format-list-bulleted menu-icon"></i></span>
        <span class="menu-title">البلاغات</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="cards-menulistaa">
        <ul class="nav flex-column sub-menu">
          @if($me->hasPermission(\App\Models\Permission::PERMISSION_CUSTOMER_REPORTS_NAME))
          <li class="nav-item" style="margin:0px"> <a class="nav-link" href="manage-customers-reports">بلاغات الزبائن</a></li>
          @endif
          @if($me->hasPermission(\App\Models\Permission::PERMISSION_TECHNICAIN_REPORTS_NAME))
          <li class="nav-item" style="margin:0px"> <a class="nav-link" href="manage-technicain-reports">بلاغات الفنيين</a></li>
          @endif
        </ul>
      </div>
    </li>
    @endif
    <!--  :::: Finance -->
    
    
    @if($me->hasPermission(\App\Models\Permission::PERMISSION_PREPAIDCARDS_HISTORY_NAME)
    &&  $me->hasPermission(\App\Models\Permission::PERMISSION_VIEW_TRANSACTIONS_NAME))
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="finance-stats-report" aria-expanded="false" aria-controls="cards-menulistbb">
        <span class="icon-bg" style="margin:5px"><i class="mdi mdi-format-list-bulleted menu-icon"></i></span>
        <span class="menu-title">الاحصائات المالية</span>
      </a>
    </li>
    @endif
  </ul>
  <div style="margin:0 auto; text-align:center; width:100%">
  فني لعندك 
  <br>
  جميع الحقوق محفوظة
  2023-2024م
  </div>
</nav>
