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
    public function panel(Request $request)
    {
	$oUser = Auth::user();
	$oPanel = Panel::where('id', $request->id)->first();
	return view('panel', [
		'oUser' => $oUser, 
		'oPanel' => $oPanel, 
		'active' => 'panel_ol11_link'
	]);
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
    
    /**
     * Show page for editing panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function editPanelPage(Request $request)
    {
	$oUser = Auth::user();
	$oPanel = Panel::where('id', $request->id)->first();
	return view('admin/panel_edit', [
		'oUser' => $oUser, 
		'oPanel' => $oPanel, 
		'active' => 'panel_ol11_link']);
    }
    
    /**
     * Save info about panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePanel(Request $request)
    {
	$oPanel = Panel::where('id', $request->id)->first();
	$aFields = array('name', 'description');

	if ($oPanel) {
	    foreach($aFields as $sField) {
		$oPanel->{$sField} = $request->{$sField};
	    }

	    $oPanel->Save();
	}

	return response()->json(array('result' => 'ok'));
    }
    
}

