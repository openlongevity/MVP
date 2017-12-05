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
		'active' => 'admin_panels_link']);
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
    
    /**
     * Show page with panel user markers.
     *
     * @return \Illuminate\Http\Response
     */
    public function panelMarkers(Request $request)
    {
	$oUser = Auth::user();
	$oPanel = Panel::where('id', $request->id)->first();
	$aSeries = PanelUserSeries::
		where('panel_id', $request->id)
		->where('user_id', $oUser->id)
		->get();
	$aRes = array();
	$aSeriesIds = array();
	foreach($aSeries as $oSeries) {
	    $aRes[$oSeries->id] = array('date' => $oSeries->date, 'markers' => array());
	    $aSeriesIds[] = $oSeries->id;
	}
	
	$aUserPanelMarkers = PanelUserSeriesMarker::whereIn('series_id', $aSeriesIds)->get();
	$aUserPanelMarkersIds = array();
	foreach($aUserPanelMarkers as $oUserPanelMarker) {
	    $aUserPanelMarkersIds[] = $oUserPanelMarker->user_marker_id;
	}
	$aMarkers = UserMarker::whereIn('id', $aUserPanelMarkersIds)->get()->keyBy('id');

	foreach($aUserPanelMarkers as $oUserPanelMarker) {
	    $oMarker = $aMarkers[$oUserPanelMarker->user_marker_id];
	    $aRes[$oUserPanelMarker->series_id]['markers'][$oMarker->marker_id] = $oMarker;
	}

	return view('panel_markers', [
		'oUser' => $oUser, 
		'oPanel' => $oPanel, 
		'aRes' => $aRes,
		'aSeries' => $aSeries,
		'active' => 'panel_ol11_link'
	]);
    }
    
    
    /**
     * Save user panel markers.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUserPanelMarkers(Request $request)
    {
	$oUser = Auth::user();
	
	// Create panel user seris.
	$oSeries = new PanelUserSeries();
	$oSeries->panel_id = $request->id;
	$oSeries->user_id = $oUser->id;
	$oSeries->date = date('Y-m-d');
	$oSeries->Save();


	$oPanel = Panel::where('id', $request->id)->first();
	$aPanelMarkers = PanelMarker::where('panel_id', $request->id)
		->get();
	foreach($aPanelMarkers as $oPanelMarker) {
	    if (isset($request->{"marker_".$oPanelMarker->marker_id}) 
		&& !empty($request->{"marker_".$oPanelMarker->marker_id})) {
		// Create user marker;
		$oMarker = new UserMarker();
		$oMarker->user_id = $oUser->id;
		$oMarker->marker_id = $oPanelMarker->marker_id;
		$oMarker->value = $request->{"marker_".$oPanelMarker->marker_id};
		$oMarker->fail = 0;
		$oMarker->Save();

		// Connect marker to series.
		$oMSeries = new PanelUserSeriesMarker();
		$oMSeries->series_id = $oSeries->id;
		$oMSeries->user_marker_id = $oMarker->id;
		$oMSeries->Save();

	    }
	}
	
	
	return response()->json(array('result' => 'ok'));
    }
    
    /**
     * Show page with panel info.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests(Request $request)
    {
	$oUser = Auth::user();
	$aSeries = PanelUserSeries::orderBy('date', 'desc')->get();
	$aPanels = Panel::get()->keyBy('id');
	$aUsers = User::get()->keyBy('id');
	return view('admin/requests', [
		'oUser' => $oUser, 
		'aSeries' => $aSeries, 
		'aPanels' => $aPanels, 
		'aUsers' => $aUsers, 
		'active' => 'admin_requests_link'
	]);
    }
    
    /**
     * Show page with panel info.
     *
     * @return \Illuminate\Http\Response
     */
    public function addInterpretationFile(Request $request)
    {
	$pdf = $request->{"input-interpretation-file"};
	// Save file.  
        $destinationPath = "interpretation_files/";
	$filename = $request->id."_".$pdf->getClientOriginalName();
	$pdf->move($destinationPath, $filename);

	$oSeries = PanelUserSeries::where('id', $request->id)->first();
	$oSeries->interpretation_file = $filename;
	$oSeries->Save();

	return response()->json(array('result' => 'ok'));
    }
    
}

