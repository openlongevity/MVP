<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use App\Panel;
use App\PanelMarker;
use App\UserMarker;
use App\Marker;
use App\PanelUserSeries;
use App\PanelUserSeriesMarker;
use Auth;
use Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class FilesController extends Controller
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
     * Get file for data with series.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataFile(Request $request)
    {
	return $this->getFile($request, 'data_file');
    }


    /**
     * Get interpretation file for series.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInterpretationFile(Request $request)
    {
	return $this->getFile($request, 'interpretation_file');
    }


    private function getFile(Request $request, $fType) {
	$oUser = Auth::user();
	$oSeries = PanelUserSeries::where('id', $request->series_id)
		->first();
	if ($oSeries->user_id == $oUser->id || $oUser->admin == 1) {
	    if ($oSeries && $oSeries->{$fType}) {
		$file = File::get($fType.'s/'.$oSeries->{$fType});
		$response = Response::make($file, 200);
		$response->header('Content-Type', 'application/pdf');
		return $response;
	    }
	}

	return view('errors/notaccess', ['oUser' => $oUser, 'active' => 'profile_link']);
    }
    
    /**
     * Get marker file file for series.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMarkerFile(Request $request)
    {
	$fType = 'marker_file';
	$oUser = Auth::user();
	$oUserMarker = UserMarker::where('id', $request->user_marker_id)
		->first();
	if ($oUserMarker->user_id == $oUser->id || $oUser->admin == 1) {
	    if ($oUserMarker->data_file) {
		$file = File::get($fType.'s/'.$oUserMarker->data_file);
		$response = Response::make($file, 200);
		if ($oUserMarker->data_file_mime) {
		    $response->header('Content-Type', $oUserMarker->data_file_mime);
		}
		return $response;
	    }
	}

	return view('errors/notaccess', ['oUser' => $oUser, 'active' => 'profile_link']);
    }


}    


