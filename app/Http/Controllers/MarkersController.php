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

class MarkersController extends Controller
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
     * Show page with markers.
     *
     * @return \Illuminate\Http\Response
     */
    public function markers(Request $request)
    {
	$oUser = Auth::user();
	$oPanel = Panel::where('id', $request->id)->first();
	$aMarkers = Marker::get();
	return view('admin/markers', [
		'oUser' => $oUser, 
		'aMarkers' => $aMarkers, 
		'oPanel' => $oPanel, 
		'active' => 'admin_markers_link'
	]);
    }
    
    /**
     * Show page for editing marker.
     *
     * @return \Illuminate\Http\Response
     */
    public function editMarker(Request $request)
    {
	$oUser = Auth::user();
	$marker = Marker::where('id', $request->id)->first();
	if ($marker) {
	    return view('admin/marker_edit', [
		'oUser' => $oUser, 
		'marker' => $marker, 
		'active' => 'admin_markers_link'
	    ]);
	}
	
	return view('errors/notaccess', ['oUser' => $oUser, 'active' => 'admin_markers_link']);
    }
    
    
    /**
     * Save info about marker.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveMarker(Request $request)
    {
	$oMarker = Marker::where('id', $request->id)->first();
	$aFields = array('name', 'names', 'names_en', 'desc', 'desc_short', 'method', 'units', 'units_full', 'preparing', 'biomaterial');

	if ($oMarker) {
	    foreach($aFields as $sField) {
		$oMarker->{$sField} = $request->{$sField};
	    }

	    $oMarker->Save();
	}

	return response()->json(array('result' => 'ok'));
    }
    
}    


