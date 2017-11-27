<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;

/**
 * Represent waypoint of task.
 */
class Marker extends Model {

    //
    protected $table = 'marker';
    protected $primaryKey = 'id';

    /**
     * Returns first 50 symbols of name of marker.
     */ 
    public function getShortName() {
	if (mb_strlen($this->name) > 50) {
	    return mb_substr($this->name, 0, 50)."...";
	}

	return $this->name;
    }
}
