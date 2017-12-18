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
use App\PanelMarkerReference;
use Auth;
use Log;
use DB;
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
	$aMarkers = Marker::get()->keyBy('id');
	return view('admin/panel_edit', [
		'oUser' => $oUser, 
		'oPanel' => $oPanel, 
		'allMarkers' => $aMarkers,
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
	    $aRes[$oSeries->id] = array('date' => $oSeries->date, 'interpretation_file' => $oSeries->interpretation_file, 'markers' => array());
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
	$oseries->panel_id = $request->id;
	$oseries->user_id = $oUser->id;
	$oseries->date = date('y-m-d');
	$oseries->save();


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
     * Adds file with interpretation.
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
    
    /**
     * Adds file with interpretation.
     *
     * @return \Illuminate\Http\Response
     */
    public function addDataFile(Request $request)
    {
	$oUser = Auth::user();
	
	// Create panel user seris.
	$oSeries = new PanelUserSeries();
	$oSeries->panel_id = $request->panel_id;
	$oSeries->user_id = $oUser->id;
	$oSeries->date = date('y-m-d');
	$oSeries->save();
	
	$pdf = $request->{"input-data-file"};
	// Save file.  
        $destinationPath = "data_files/";
	$filename = $oSeries->id."_".$pdf->getClientOriginalName();
	$pdf->move($destinationPath, $filename);

	$oSeries->data_file = $filename;
	$oSeries->Save();

	return response()->json(array('result' => 'ok'));
    }
    
    /**
     * Adds marker to panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function addMarkerToPanel(Request $request)
    {
	$oPanelMarker = PanelMarker::where('marker_id', $request->marker_id)->first();
	if ($oPanelMarker) {
	    return response()->json(array('error' => 2));
	}
	
	if (!isset($request->marker_id)) {
	    return response()->json(array('error' => 1));
	}

	$oMarker = Marker::where('id', $request->marker_id)->first();
	if (!$oMarker) {
	    return response()->json(array('error' => 1));
	}

	$oPanelMarker = new PanelMarker();
	$oPanelMarker->panel_id = $request->panel_id;
	$oPanelMarker->marker_id = $request->marker_id;
	$oPanelMarker->Save();

	$oPanel = Panel::where('id', $request->panel_id)->first();
	
	$view = View::make('admin/panel_edit_marker_row', [
		'oMarker' => $oMarker,
		'oPanel' => $oPanel
	]);
	$sHtml = $view->render();

	return response()->json(array('result' => 'ok', 'html' => $sHtml));
    }
    
    
    /**
     * Deletes marker from panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteMarkerFromPanel(Request $request)
    {
	$oPanelMarker = PanelMarker::where('marker_id', $request->marker_id)
	    ->where('panel_id', $request->panel_id)
	    ->first();
	if (!$oPanelMarker) {
	    return response()->json(array('error' => 1));
	}
	$oPanelMarker->Delete();
	
	return response()->json(array('result' => 'ok'));
    }
    
    /**
     * Returns html with table with references.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTableReference(Request $request)
    {
	$aMarkerRefs = PanelMarkerReference::where('panel_id', $request->panel_id)
		->where('marker_id', $request->marker_id)
		->get();
	$view = View::make('admin/references_table', [
		'panel_id' => $request->panel_id,
		'aMarkerRefs' => $aMarkerRefs,
	]);
	$sHtml = $view->render();

	return response()->json(array('result' => 'ok', 'html' => $sHtml));
    }
    
    
    /**
     * Returns code with row with empty reference.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRowWithReference(Request $request)
    {
	$view = View::make('admin/reference_row', [
		'index' => $request->index,
	]);
	$sHtml = $view->render();

	return response()->json(array('html' => $sHtml));
    }
    
    
    /**
     * Save new references for panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateReferences(Request $request)
    {
	// Delete all previous reference
	$qDelete = DB::table('panel_marker_reference')->where('marker_id', $request->marker_id);
	if (isset($request->{"panel_id"})) {
	    $qDelete = $qDelete->where('panel_id', $request->panel_id);
	}

	$qDelete->delete();

	    
	// Add new reference.
	$aFields = array('sex', 'ref_min', 'ref_max', 'panel_id', 'marker_id');
	for ($index = 0; $index <= $request->index; $index++) {
	    if (isset($request->{"sex_".$index})) {
		$oPanelReference = new PanelMarkerReference();
		foreach($aFields as $sField) {
		    if (isset($request->{$sField."_".$index})) {
			$oPanelReference->{$sField} = $request->{$sField."_".$index};
		    }
		}
		if (isset($request->{"age_".$index}) && $request->{"age_".$index} == 1) {
		    $oPanelReference->{"age_min"} = $request->{"age_min_".$index};
		    $oPanelReference->{"age_max"} = $request->{"age_max_".$index};
		}
		if (isset($request->{"panel_id"})) {
		    $oPanelReference->{"panel_id"} = $request->{"panel_id"};
		}
		$oPanelReference->{"marker_id"} = $request->{"marker_id"};

		$oPanelReference->Save();
	    }
	}
	return response()->json(array('result' => 'ok'));
    }
    
    
    /**
     * Show page with request of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function request(Request $request)
    {
	$oUser = Auth::user();
	$oSeries = PanelUserSeries::where('id', $request->id)->first();
	$oPanel = Panel::where('id', $oSeries->panel_id)->first();
	$oUserRequest = User::where('id', $oSeries->user_id)->first();
	$aSeriesMarkers = PanelUserSeriesMarker::where('series_id', $oSeries->id)->get()->keyBy('user_marker_id');

	$aUserMarkerIds = array();
	foreach($aSeriesMarkers as $oSeriesMarker) {
	    $aUserMarkerIds[] = $oSeriesMarker->user_marker_id;
	}
	$aUserMarkers = UserMarker::whereIn('id', $aUserMarkerIds)->get()->keyBy('marker_id');
	return view('admin/request', [
		'oUser' => $oUser, 
		'oSeries' => $oSeries, 
		'oPanel' => $oPanel, 
		'oUserRequest' => $oUserRequest, 
		'aSeriesMarkers' => $aSeriesMarkers, 
		'aUserMarkers' => $aUserMarkers, 
		'active' => 'admin_requests_link'
	]);
    }
    
}

