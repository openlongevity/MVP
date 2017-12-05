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
}    


