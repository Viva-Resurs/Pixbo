<?php

namespace App\Http\Middleware;

use Closure;
use App\Jobs\SetLocale;
use Illuminate\Bus\Dispatcher as BusDispatcher;

class Localization
{

    protected $bus;
    protected $setLocale;

    public function __construct(BusDispatcher $bus, SetLocale $setLocale)
    {
        $this->bus = $bus;
        $this->setLocale = $setLocale;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->bus->dispatch($this->setLocale);
        return $next($request);
    }
}
