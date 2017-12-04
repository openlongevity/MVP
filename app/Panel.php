<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Marker;
use App\PanelMarker;


/**
 * Represent panel.
 */
class Panel extends Model {

    //
    protected $table = 'panels';
    protected $primaryKey = 'id';

    private $aMarkers = null;

    /**
     * Returns markers of panel.
     */ 
    public function getMarkers() {
	if (!$this->aMarkers) {
	    $aMarkers = Marker::whereIn('id', PanelMarker::where('panel_id', $this->id)
							    ->pluck('marker_id')
							    ->toArray())
		    ->get();
	    $this->aMarkers = $aMarkers;
	}

	return $this->aMarkers;
    }
}


