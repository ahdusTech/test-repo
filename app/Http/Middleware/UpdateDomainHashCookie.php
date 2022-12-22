<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class UpdateDomainHashCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHttpHost();

        $appUrl = config('app.url');

        // Check, if the app-url matches the current host
        if( preg_match("/http(s)?:\/\/$host(:[0-9]*)?/", $appUrl) ) {
            if ($request->hash) {
                // set hash of the requested domain as cookie to be able to
                // navigate from static-page back to landing page
                // cookie is saved for landing page domain
                Cookie::queue('domain_hash', $request->hash);
            }
        }

        return $next($request);
    }
}
