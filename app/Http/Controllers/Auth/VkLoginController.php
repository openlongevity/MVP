<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;
use App\User;
use App\UserSSProvider;
use Auth;
use Log;

class VkLoginController extends LoginController
{
    private $provider = 'vkontakte';
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
    public function vkRedirect()
    {
        return Socialite::driver($this->provider)->fields(self::vkFields)->redirect();
    }

    public function vkCallback()
    {
        $vkUser = Socialite::driver($this->provider)->fields(self::vkFields)->user();
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
	// Gender.
	$gender = 0;
	if (isset($raw['sex']) && $raw['sex'] == 1) { // vk sex = 2 - male, sex = 1 - female.
	    $gender = 1;
	
	}

	$aUserParams = [
            'name'     => $raw['first_name'],
	    'email'    => $user->email,
	    'gender'   => $gender,
        ];
	
	// Birthday.
	if (isset($raw['bdate'])) {
	    $time = strtotime($raw['bdate']);
	    $aUserParams['birthday'] = date('Y-m-d', $time);
	}
	
	// Avatar.
	if (isset($raw['photo_max_orig'])) {
	    $aUserParams['avatar'] = $raw['photo_max_orig'];
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


