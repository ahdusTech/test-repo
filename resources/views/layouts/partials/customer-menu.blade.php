<button class="btn dropdown-toggle" type="button" id="customer" data-preffered-lang="{{session('preferred_lang')}}" data-toggle="dropdown" aria-expanded="false">
    <strong>{{auth()->guard('customer')->user()->full_name()}}</strong>
</button>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="customer">
    <a  href="{{ route('customer.dashboard') }}">
        <button class="btn " type="button" id="user"   role="button">
            <i class=" fas fa-tachometer-alt"></i> Kundenbereich
        </button>
    </a>
    </br>
    <a  href="{{ route('customer.logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <button class="btn " type="button" id="user"   role="button">
            <i class="fas fa-sign-out-alt"></i> {{__('auth.logout')}}
        </button>
    </a>
    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
