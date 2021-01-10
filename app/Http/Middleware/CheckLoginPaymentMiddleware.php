<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
session_start();
class CheckLoginPaymentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Session::get('customer_id'))
            {
                    return redirect('dang-nhap');
                  }
            else
            {
                        return $next($request);
            }
    }
}
