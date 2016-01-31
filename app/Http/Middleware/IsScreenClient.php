<?php

namespace App\Http\Middleware;

use App\Models\Client;
use App\User;
use Auth;
use Closure;

class IsScreenClient {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$ip_address = $request->getClientIp(true);
		$client     = Client::where(['ip_address' => $ip_address])->first();

		if (!is_null($client)) {
			$user = User::where(['id' => $client->user_id])->first();
			Auth::logout();
			Auth::login($user);

			return redirect('play');
		}

		return $next($request);
	}
}
