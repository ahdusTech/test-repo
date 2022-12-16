<button class="btn dropdown-toggle" type="button" id="language"   data-toggle="dropdown" aria-expanded="false">
    <img src="/img/{{LaravelLocalization::getCurrentLocale()}}.png" alt="Flag" width="25">
    <strong>{{__('messages.' . LaravelLocalization::getCurrentLocale())}}</strong>
</button>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="language">
    <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('de') }}">
        <img src="/img/de.png" alt="Flag" width="20">
        {{__('messages.de')}}
    </a>
    <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en') }}">
        <img src="/img/en.png" alt="Flag" width="20">
        {{__('messages.en')}}
    </a>
</div>
