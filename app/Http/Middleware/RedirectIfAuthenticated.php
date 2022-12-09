<?php

namespace App\Http\Middleware;

use App\Models\Customer\Customer;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
       /* if ($guard == "customer" && Auth::guard($guard)->check()) {
            return redirect()->route('customer.dashboard');
        }
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }*/
        /*if ($request->is('customer') || $request->is('customer/*')) {
            if (Auth::guard(Customer::$guardType)->check()) {
                return redirect()->route('customer.dashboard');
            }
            return redirect()->guest('/customer/login');
        }
        if ($request->is('admin') || $request->is('admin/*')) {
            if (Auth::guard('web')->check()) {
                return redirect()->route('dashboard');
            }
            return redirect()->guest('/customer/login');
        }*/

        return $next($request);
    }
}
