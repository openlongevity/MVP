<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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
     * Show the user profile for editing.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileSave()
    {
        return view('profile');
    }
}

