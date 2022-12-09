<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('customer.dashboard')}}" class="brand-link">
        <img src="{{url('img/white_logo.png')}}" style="width: 60%; margin-left: 45px; margin-right: 15px;"/>
    </a>
    <div class="brand-link" id="clock" style="text-align: center;font-size: 12px;padding: 7px">
        {{date('Y-m-d')}}&nbsp;&nbsp;&nbsp;{{date('H:i:s')}}
    </div>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('customer.dashboard')}}" class="nav-link @if(Route::currentRouteName() == 'customer.dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{__('customers-sidebar.dashboard')}}
                        </p>
                    </a>
                </li>
                {{--<li class="nav-item">
                    <a href="{{route('customer.auction')}}" class="nav-link @if(Route::currentRouteName() == route('customer.auction')) active @endif">
                        <i class="nav-icon fas fa-gavel"></i>
                        <p> {{__('customers-sidebar.auction')}} </p>
                    </a>
                </li>--}}


                <li class="nav-item @if(Route::currentRouteName() == 'customer.profile' or Route::currentRouteName() == 'customer.delete' or Route::currentRouteName() == 'customer.2fa-settings') menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p> Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('customer.profile')}}" class="nav-link @if(Route::currentRouteName() == 'customer.profile') active @endif">
                                <i class="nav-icon fas"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customer.2fa-settings')}}" class="nav-link @if(Route::currentRouteName() == 'customer.2fa-settings') active @endif">
                                <i class="nav-icon fas"></i>
                                <p>Security</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customer.delete')}}"  class="nav-link  @if(Route::currentRouteName() == 'customer.delete') active @endif">
                                <i class="nav-icon fas"></i>
                                <p>Delete account</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>
