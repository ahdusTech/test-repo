<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" data-lang="#" data-locale="{{session('locale')}}">
                {{ Auth::guard('customer')->user()->first_name . ' ' . Auth::guard('customer')->user()->last_name }}
                &nbsp;<i class="fas fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
               {{-- <a class="nav-link" href="{{ route('customer.2fa-settings') }}">
                    <i class="fas fa-fingerprint"></i>&nbsp;&nbsp;{{__('customers-nav.2fa_settings')}}
                </a>--}}
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{ route('customer.logout') }}"
                   onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" role="button">
                    <i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;{{__('auth.logout')}}
                </a>
            </div>
        </li>
        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </ul>
</nav>
