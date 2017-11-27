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
        return view('profile', ['oUser' => $oUser, 'active' => 'profile_link']);
    }
    
    /**
     * Show the user profile for editing.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileEdit()
    {
	$oUser = Auth::user();
        return view('profile_edit', ['oUser' => $oUser, 'active' => 'profile_link']);
    }
    
    /**
     * Save user profile to database.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileSave(Request $request)
    {
	if (!isset($request->name) || empty($request->name)) {
	    return response()->json(array('error' => 1));
	}
	if (!isset($request->profile_height) || empty($request->profile_height)
		|| !is_numeric($request->profile_height)
		|| $request->profile_height < 50
		|| $request->profile_height > 250) {
	    return response()->json(array('error' => 2));
	}
	$oUser = Auth::user();
	$aFields = array('profile_first_name', 'profile_second_name', 'profile_middle_name',
		'profile_about', 'profile_height', 'profile_marital_status', 'profile_children', 
		'profile_location', 'profile_location_birth', 'gender', 'birthday', 'name');
	foreach($aFields as $sField) {
	    if (isset($request->{$sField})) {
		$oUser->{$sField} = $request->{$sField};
	    }
	}
	$oUser->Save();
	return response()->json(array('result' => 'ok'));
    }
}

