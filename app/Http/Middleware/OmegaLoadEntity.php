<?php

namespace Omega\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Omega\Facades\Entity;
use Omega\Facades\OmegaUtils;
use Omega\Utils\Entity\Site;

class OmegaLoadEntity
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(OmegaUtils::isInstalled()){
            Entity::setSite(new Site());
        }

        return $next($request);
    }
}
