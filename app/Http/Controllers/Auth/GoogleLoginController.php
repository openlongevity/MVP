<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;
use App\User;
use App\UserSSProvider;
use Auth;
use Log;

class GoogleLoginController extends LoginController
{
    private $provider = 'google';
    /**
     * Initialize Facebook fields to override
     */
    const vkFields = [
	'id',
	'email',
        'first_name', // Default
        'last_name', // Default
        'sex', // Default
	'bdate',
	'city',	
	'photo_max_orig',
    ];

    public function gpRedirect()
    {
        return Socialite::driver($this->provider)->redirect();
    }

    public function gpCallback()
    {
        $vkUser = Socialite::driver($this->provider)->user();
	$authUser = $this->findOrCreateUser($vkUser, $this->provider);
	Auth::login($authUser, true);
	return redirect($this->redirectTo);
    }
    
    
    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
	}

	$raw = $user->getRaw();
	foreach($raw as $key => $value) {
	    if (is_array($value)) {
		Log::info($key.' => array');
		foreach($value as $key1 => $value1) {
		    if (is_array($value1)) {
			foreach($value1 as $key2 => $value2) {
			    Log::info($key.' => '.$key1.' => '.$key2.' => '.$value2);
			}
		    } else {
			Log::info($key.' => '.$key1.' => '.$value1);
		    }
		}
	    } else {
		Log::info($key.' => '.$value);
	    }
	}
	// Gender.
	$gender = 0;
	if (isset($raw['gender']) && $raw['gender'] != 'male') { 
	    $gender = 1;
	
	}

	$aUserParams = [
            'name'     => $raw['displayName'],
	    'email'    => $user->email,
	    'gender'   => $gender,
        ];
	
	// Avatar.
	if (isset($raw['image'])) {
	    $aUserParams['avatar'] = $raw['image']['url'];
	}
	
	$authUser = User::create($aUserParams);
	
	UserSSProvider::create([
            'user_id' => $authUser->id,
            'provider' => $provider,
            'provider_id' => $user->id,
	]);
	
	return $authUser;
    }
}



