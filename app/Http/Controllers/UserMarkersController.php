<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\UserMarker;
use Auth;
use Log;

class UserMarkersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function userMarkers()
    {
	$oUser = Auth::user();
	$aUserMarkers = UserMarker::where('user_id', $oUser->id)->get();
	return view('user_markers', ['oUser' => $oUser, 
		'markers' => $aUserMarkers, 
		'active' => 'my_markers_link']);
    }
    
}
