<?php

namespace App\Http\Middleware;

use App\Models\Customer\Customer;
use Closure;
use Illuminate\Support\Facades\Auth;

class TestServer
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
        if(env('APP_URL') != 'https://adomino.net'){
            $locked_status = session()->get('locked_status');
            if ($locked_status and $locked_status == 'unlock') {
                return $next($request);
            }
            return redirect()->route('request_access');
        }
        return $next($request);
    }
}
