<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\Panel;
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
    
    /**
     * Show admin page with list of panels.
     *
     * @return \Illuminate\Http\Response
     */
    public function panels()
    {
	$oUser = Auth::user();
	$aPanels = Panel::get();
	return view('admin/panels', [
		'oUser' => $oUser, 
		'panels' => $aPanels,
		'active' => 'panel_ol11_link']);
    }
}

