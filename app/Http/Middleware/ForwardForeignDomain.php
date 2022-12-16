<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class ForwardForeignDomain
{
    /**
     * This middleware checks, if the current request comes from another domain then
     * the original project-domain.
     *
     * If the domain is different, the domain from the current request is encrypted
     * and the user gets forwarded to the app-domain. The current domain is passed
     * encrypted as url-parameter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the current host (e.g. schlafen.de)
        $host = trim($request->getHttpHost(), '.');

        // App-Domain (e.g. adomino.net)
        $appUrl = config('app.url');

        // Check, if the app-url matches the current host
      //  if( !preg_match("/http(s)?:\/\/$host(:[0-9]*)?/", $appUrl) ) {

            // The requesting host does not match the app-url
            // We need to encrypt the current host and forward the user to the main-domain
        //    $hash = Crypt::encryptString($host);

          //  $url = $appUrl . route('landingpage.domain', [ 'hash' => $hash], false );

            // Redirect the user to the landingpage with hashed domain
            //return redirect( $url );

//        }

        return $next($request);
    }
}
