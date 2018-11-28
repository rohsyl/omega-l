<?php

namespace Omega\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class AdminLocale
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
        if(session()->has('admin.lang')){
            $locale = session('admin.lang');
        }
        else{
            $locale = om_config('om_lang');
        }
        App::setLocale($locale);

        return $next($request);
    }
}
