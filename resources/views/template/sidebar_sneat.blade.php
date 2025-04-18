<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="menus-9 menu menu-vertical d-inline-flex bg-menu-theme me-6">
    <div class="app-brand mb-4 border" style="padding-top: 1rem;padding-left: 2rem;padding-bottom: 1rem;">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
          <img src="{{asset('/img/siplogooke.webp')}}" alt="icon-mini" width="30px" height="40px">
        </span>
        <span class="app-brand-text demo menu-text fw-bold ms-2">SIMS-APP</span>
      </a>
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
      </a>
    </div>

    <div class="menu-block my-2 d-flex align-items-center">
      <div class="avatar avatar-lg me-2">
        @if(Auth::User()->avatar != NULL)
          <img src="{{Auth::User()->avatar}}" class="rounded-circle shadow">
        @else
          @if(Auth::User()->gambar == NULL || Auth::User()->gambar == "-")
            <img src="{{asset('image/default-user.png')}}" class="rounded-circle shadow" alt="User Image">
          @else
            <img src="{{asset('image') . '/' . Auth::User()->gambar}}" class="rounded-circle shadow" alt="User Image">
          @endif
        @endif
      </div>
      <h6 class="menu-text mt-4 mb-1 user-name" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;display: block;max-width: 25ch;">{{ Auth::User()->name }}</h6>
      <div class="small">
        <a class="menu-link" style="text-align: center;" href="javascript:void(0)">{{$initView['userRole']->name}}</a>
      </div>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Pages -->
      @foreach($initView['listMenu'] as $key => $group)
      <li class="menu-item" style="margin:0.200rem 0!important">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons {{$group[0]->icon_group}}"></i>
          <div class="text-truncate" data-i18n="Account Settings">{{$key}}</div>
        </a>
        <ul class="menu-sub">
          @foreach($group as $keys => $childGroup)
            @if($group[$keys]->count == 0)
              <li class="menu-item">
                <a href="{{url($group[$keys]->url)}}" class="menu-link">
                  <div class="text-truncate" data-i18n="Account">
                    {{$group[$keys]->name}}
                    @if($group[$keys]->name == "Draft PR" && isset($initView['countPRByCircularBy']))
                      @if($initView['countPRByCircularBy'] > 0)
                      <span class="draft-count badge rounded-pill bg-danger">{{$initView['countPRByCircularBy']}}</span>
                      @endif
                    @endif
                    @if($group[$keys]->name == "Lead Register")
                    <span class="pull-right-container">
                      <small class="badge pull-right rounded-pill bg-danger" id="Lead_Register"></small>
                    </span>
                    @endif  
                  </div>
                </a>
              </li>
            @else
              @if($group[$keys]->name == "Consumable" || $group[$keys]->name == 'ICM' || $group[$keys]->name == 'SAL' || $group[$keys]->name == 'PPM' || $group[$keys]->name == 'SPM' || $group[$keys]->name == 'HCM' || $group[$keys]->name == 'SAL' || $group[$keys]->name == 'FAT' || $group[$keys]->name == 'SSM')
              <li class="menu-item open" style="">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                  <div data-i18n="Multi Level">{{$group[$keys]->name}}</div>
                </a>
                <ul class="menu-sub">
                  @foreach($group[$keys]->child as $childRow)
                    @foreach($childRow as $childRowData)
                    <li class="menu-item">
                      <a href="{{url($childRowData->url)}}" class="menu-link">
                        <div data-i18n="Level 3">{{$childRowData->name}}</div>
                      </a>
                    </li>
                    @endforeach
                  @endforeach
                </ul>
              </li>
              @endif
            @endif
          @endforeach
        </ul>
      </li>
      @endforeach
    </ul>
  </div>
</aside>
<!-- / Menu -->