<?php

namespace App\Http\Middleware;

use Closure;

class IsScreenClient
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
        $client = \App\Client::where(['ip' => $request->getClientIp(true)])->get();
        dd($client);
        return $next($request);
    }
}
