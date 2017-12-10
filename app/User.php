<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Helper;
use App\UserMarker;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Marital status in lang.
     *
     * @var array
     */
    protected $maritalStatus = [
        'Холост', 'Женат', 'Разведен'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'avatar', 'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Returns full name of user.
     */ 
    public function getName() {
	if ($this->name && !empty($this->name)) {
	    return $this->name;
	}

	return $this->email;
    }

    /**
     * Returns short name of user.
     */ 
    public function getShortName() {
	if ($this->profile_first_name && !empty($this->profile_first_name)) {
	    // return trim($this->profile_second_name.' '.$this->profile_first_name);
	}

	if ($this->name && !empty($this->name) && strpos($this->name, ' ')) {
	    return substr($this->name, 0, $this->strrevpos($this->name, ' '));
	}
	if ($this->name && !empty($this->name)) {
	    return $this->name;
	}

	return $this->email;

    }
    
    /**
     * Returns link to avatar.
     */ 
    public function getAvatarLink() {
	if ($this->avatar) {
	    return $this->avatar;
	}

	return '/images/no_avatar.jpg';

    }
    
    /**
     * Returns amount of ages due to birthday.
     */ 
    public function getAges() {
	$birthDate = explode("-", $this->birthday);
	//get age from date or birthdate
	$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[1]))) > date("md")
	    ? ((date("Y") - $birthDate[0]) - 1)
	    : (date("Y") - $birthDate[0]));

	return $age.' '.Helper::getPluralForm($age, ['год', 'года', 'лет']);
    }
    
    /**
     * Returns lang marital status.
     */ 
    public function getMaritalStatus() {
	$index = $this->profile_marital_status;
	if ($index > count($this->maritalStatus) - 1) {
	    $index = 0;
	}
	return $this->maritalStatus[$index];
    }

    /**
     * use strrevpos function in case your php version does not include it
     */ 
    private function strrevpos($instr, $needle) {
	$rev_pos = strpos (strrev($instr), strrev($needle));
	if ($rev_pos===false) return false;
	else return strlen($instr) - $rev_pos - strlen($needle);
    }
    
    
    /**
     * Returns lang marital statuses.
     */ 
    public function getMaritalStatuses() {
	return $this->maritalStatus;
    }

    /**
     * Returns list of user markers.
     */ 
    public function getMarkers() {
	return UserMarker::where('user_id', $this->id)
		->where('deleted', 0)
		->get();
    }

}
