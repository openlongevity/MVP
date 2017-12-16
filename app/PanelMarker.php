<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PanelMarkerReference;

/**
 * Represent marker of panel.
 */
class PanelMarker extends Model {

    protected $aReferences = null;
    //
    protected $table = 'panel_markers';
    protected $primaryKey = 'id';

    public function refs() {
	if (!$aReferences) {
	    $aReferences = PanelMarkerReference::where('marker_id', $this->marker_id)
		    ->where('panel_id', $this->panel_id)
		    ->get();
	}

	return $aReferences;
    }
}



