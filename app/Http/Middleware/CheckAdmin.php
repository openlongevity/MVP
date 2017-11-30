<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Auth;

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

	return redirect('/notaccess');
    }
}
