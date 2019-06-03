<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class AddServiceId adds a unique service ID to each incoming request
 *
 * @package App\Http\Middleware
 */
class ServiceIdentifier
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
        $request->request->add(['sid' => \App\Lib\ServiceIdentifier::Create()]);

        return $next($request);
    }
}
