<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Panel;
use App\PanelMarker;
use App\UserMarker;
use App\Marker;
use App\PanelUserSeries;
use App\PanelUserSeriesMarker;
use Auth;
use Log;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
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
     * Show page with users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
	$oUser = Auth::user();
	$oPanel = Panel::where('id', $request->id)->first();
	$aUsers = User::get();
	return view('admin/users', [
		'oUser' => $oUser, 
		'aUsers' => $aUsers, 
		'oPanel' => $oPanel, 
		'active' => 'admin_users_link'
	]);
    }
}    

