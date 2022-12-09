<?php

namespace App\Http\Middleware;

use App\Models\Customer\Customer;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class isCustomer
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
        if (Auth::guard(Customer::$guardType)->check()) {
            return $next($request);
        }
        return redirect()->route('home');
    }
}
