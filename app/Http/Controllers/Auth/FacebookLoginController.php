<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;
use App\User;
use App\UserSSProvider;
use Auth;
use Log;

class FacebookLoginController extends LoginController
{
    private $provider = 'facebook';
    /**
     * Since facebook will give you name, email, gender by default,
     * You'll only need to initialize Facebook scopes after getting permission
     */
    const facebookScope = [
        'user_birthday',
    ];
    /**
     * Initialize Facebook fields to override
     */
    const facebookFields = [
        'name', // Default
        'email', // Default
        'gender', // Default
        'birthday', // I've given permission
    ];
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->fields(self::facebookFields)->scopes(self::facebookScope)->redirect();
    }

    public function facebookCallback()
    {
        $facebook = Socialite::driver('facebook')->fields(self::facebookFields)->user();
	$authUser = $this->findOrCreateUser($facebook, $this->provider);
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

	Log::info('bt:'.$user->getRaw()['gender']);
	$raw = $user->getRaw();
	// Gender.
	$gender = 0;
	if (isset($raw['gender']) && $raw['gender'] != 'male') {
	    $gender = 1;
	
	}

	$aUserParams = [
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'avatar' => $user->avatar,
            'gender' => $gender
        ];
	// Birthday.
	if (isset($raw['birthday'])) {
	    Log::info('bt2:'.$raw['birthday']);
	    $time = strtotime($raw['birthday']);
	    $aUserParams['birthday'] = date('Y-m-d', $time);

	}
	
	$authUser =  User::create($aUserParams);
	
	UserSSProvider::create([
            'user_id' => $authUser->id,
            'provider' => $provider,
            'provider_id' => $user->id,
        ]);
	
	return $authUser;
    }
}

