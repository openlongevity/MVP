<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use App\User;

/**
 * Represent waypoint of task.
 */
class UserMarker extends Model {

    //
    protected $table = 'user_markers';
    protected $primaryKey = 'id';
    protected $aReferences = null;

    
    /**
     * Returns list of references.
     */ 
    public function refs($panel_id = null) {
	if (!$this->aReferences) {
	    $this->aReferences = Helper::getRefs($this->marker_id, $panel_id);
	}

	return $this->aReferences;
    }


    /**
     * Checks weather value in reference of panel or marker.
     * return 
     *	    0 - in ref.
     *	    1 - not in ref.
     *	    2 - not determine.
     */ 
    public function checkRef($panel_id) {
	$res = 2;
	
	if (!$this->aReferences) {
	    $this->aReferences = Helper::getRefs($this->marker_id, $panel_id);
	}

	if (count($this->aReferences) == 0) {
	    return $res;
	}



	$oUser = User::where('id', $this->user_id)->first();
	$age = $oUser->getIntAges();
	if (!$oUser) {
	    return $res;
	}

	$res = 1;
	foreach($this->aReferences as $oRef) {
	    // Check min age.
	    if ($oRef->age_min && $age < $oRef->age_min) {
		continue;
	    }
	    // Check max age.
	    if ($oRef->age_max && $age > $oRef->age_max) {
		continue;
	    }
	    if ($oRef->sex > 0 && $oRef->sex != $oUser->gender + 1) {
		continue;
	    }
	    // Any sex
	    if ($this->value > $oRef->ref_min && $this->value < $oRef->ref_max) {
		return 0;
	    }
	}

	return $res;
    }
}

