<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\PanelMarkerReference;

/**
 * Represent waypoint of task.
 */
class Marker extends Model {

    //
    protected $table = 'marker';
    protected $primaryKey = 'id';
    protected $aReferences = null;

    /**
     * Returns first 50 symbols of name of marker.
     */ 
    public function getShortName() {
	if (mb_strlen($this->name) > 50) {
	    return mb_substr($this->name, 0, 50)."...";
	}

	return $this->name;
    }
    
    /**
     * Returns list of references.
     */ 
    public function refs($panel_id) {
	if (!$this->aReferences) {
	    $qGetRefs = PanelMarkerReference::where('marker_id', $this->id);
	    if ($panel_id) {
		$qGetRefs = $qGetRefs->where('panel_id', $panel_id);
	    }
	    $this->aReferences = $qGetRefs->get();
	}

	return $this->aReferences;
    }
}
