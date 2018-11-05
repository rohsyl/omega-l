<?php

namespace Omega\Http\Middleware;

use Closure;
use Omega\Facades\OmegaUtils;

class OmegaIsInstalled
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
        // if omega is installed, return a 404
        if(OmegaUtils::isInstalled()){
            return abort(404);
        }

        return $next($request);
    }
}
