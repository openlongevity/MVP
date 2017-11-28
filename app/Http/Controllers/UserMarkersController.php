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
     * Show page with user markers.
     *
     * @return \Illuminate\Http\Response
     */
    public function userMarkers()
    {
	$oUser = Auth::user();
	$aUserMarkers = UserMarker::where('user_id', $oUser->id)->orderBy('date', 'desc')->get();
	$aMarkers = Marker::get()->keyBy('id');
	$aNewUserMarkers = array();
	foreach($aUserMarkers as $oMarker) {
	    $oMarker->name = $aMarkers[$oMarker->marker_id]->name;
	    $aNewUserMarkers[] = $oMarker;
	}

	return view('user_markers', ['oUser' => $oUser, 
		'markers' => $aUserMarkers,
		'allMarkers' => $aMarkers,
		'active' => 'my_markers_link']);
    }
    
    /**
     * Returns code with row of user markers table.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRowWithMarker(Request $request)
    {
	$aMarkers = Marker::get();
	$view = View::make('user_markers_table_row', [
		'index' => $request->number,
		'marker_id' => $request->marker_id,
		'allMarkers' => $aMarkers,
	]);
	$sHtml = $view->render();

	return response()->json(array('html' => $sHtml));
    }
    
    /**
     * Show page with user markers.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveMarkers(Request $request)
    {
	$aFields = array('marker_id', 'value', 'lab_units', 'date', 'ref_lab_value_min', 'ref_lab_value_max', 'lab');
	$oUser = Auth::user();
	for($i = 1; $i <= $request->count_rows; $i++) {
	    if (isset($request->{"marker_id_".$i})) {
		$oMarker = new UserMarker();
		$oMarker->user_id = $oUser->id;
		foreach($aFields as $sField) {
		    $oMarker->{$sField} = $request->{$sField."_".$i};
		}
		$oMarker->Save();
	    }
	}
	return response()->json(array('result' => 'ok'));
    }
    
    
    /**
     * Save one marker.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveMarker(Request $request)
    {
	$aFields = array('marker_id', 'value', 'lab_units', 'date', 'ref_lab_value_min', 'ref_lab_value_max', 'lab');
	$oMarker = UserMarker::where('id', $request->id)->first();
	if ($oMarker) {
	    foreach($aFields as $sField) {
		$oMarker->{$sField} = $request->{$sField};
	    }
	    $oMarker->Save();
	}
	return response()->json(array('result' => 'ok'));
    }
    
    
    /**
     * Deletes marker by id.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteMarker(Request $request)
    {
	$oMarker = UserMarker::where('id', $request->id)->first();
	if ($oMarker) {
	    $oMarker->Delete();
	}
	return response()->json(array('result' => 'ok'));
    }
}
