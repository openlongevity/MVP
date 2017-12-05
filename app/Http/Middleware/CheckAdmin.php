<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Auth;
use Illuminate\Http\Response;

class CheckAdmin
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
	$oUser = Auth::user();
	if ($oUser && $oUser->admin == 1) {
	    return $next($request);
	}

	return new Response(view('errors/notaccess', ['oUser' => $oUser, 'active' => 'profile_link']));

    }
}
