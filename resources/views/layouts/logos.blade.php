@if (Route::currentRouteName() == 'landingpage.domain')
    @foreach ($logos as $logo)
        @if ($logo->active)
            <div class="text-center" data-toggle="tooltip" data-sort="{{$logo->sort}}" data-placement="top" title="{{$logo->purchased_domain}}">
                <img src="{{Storage::disk('public')->url($logo->logo)}}" class="img-fluid d-inline-block" alt="{{$logo->purchased_domain}}" width="80" height="40"/>
            </div>
        @endif
    @endforeach
@endif
