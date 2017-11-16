<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Log;

class ProfileController extends Controller
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
     * Show the user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
	$oUser = Auth::user();
        return view('profile');
    }
    
    /**
     * Show the user profile for editing.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileEdit()
    {
	$oUser = Auth::user();
        return view('profile', ['oUser' => $oUser]);
    }
    
    /**
     * Save user profile to database.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileSave(Request $request)
    {
	$oUser = Auth::user();
	Log::info('from save profile');
	$aFields = array('profile_first_name', 'profile_second_name', 'profile_middle_name',
		'profile_about', 'profile_height', 'profile_marital_status', 'profile_children', 
		'profile_location', 'profile_location_birth', 'gender', 'birthday');
	foreach($aFields as $sField) {
	    if (isset($request->{$sField}) && !empty($request->{$sField})) {
		$oUser->{$sField} = $request->{$sField};
	    }
	}
	$oUser->Save();
	return response()->json(array('result' => 'ok'));
    }
}

