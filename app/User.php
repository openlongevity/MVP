<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
	if ($this->profile_first_name && !empty($this->profile_first_name)) {
	    return trim($this->profile_second_name.' '.$this->profile_first_name.' '.$this->profile_middle_name);
	}
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
	    return trim($this->profile_second_name.' '.$this->profile_first_name);
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
}
