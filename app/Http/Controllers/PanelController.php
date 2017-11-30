<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\UserMarker;
use App\Marker;
use Auth;
use Log;
use Illuminate\Support\Facades\View;

class PanelController extends Controller
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
     * Show page with panel info.
     *
     * @return \Illuminate\Http\Response
     */
    public function panel()
    {
	$oUser = Auth::user();
	return view('panel', ['oUser' => $oUser, 'active' => 'panel_ol11_link']);
    }
}

