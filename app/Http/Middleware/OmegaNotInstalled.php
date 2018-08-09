<?php

namespace Omega\Http\Middleware;

use Closure;
use Omega\Utils\OmegaUtils;

class OmegaNotInstalled
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
        if(!OmegaUtils::isInstalled()){
            return redirect(route('install.index'));
        }

        return $next($request);
    }
}
