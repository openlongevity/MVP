<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Represent marker of panel.
 */
class PanelMarkerReference extends Model {

    //
    protected $table = 'panel_marker_reference';
    protected $primaryKey = 'id';

    /**
     * Returns string represendation of reference.
     */ 
    public function toString($units) {
	$res = '';

	// Sex.
	if ($this->sex == 1) {
	    $res .= 'М: ';
	}
	if ($this->sex == 2) {
	    $res .= 'Ж: ';
	}

	// Age
	if ($this->age_min && $this->age_max) {
	    $res .= $this->age_min.' - '.$this->age_max.' лет, ';
	} else if ($this->age_min) {
	    $res .= ' от '.$this->age_min.' лет, ';
	} else if ($this->age_max) {
	    $res .= ' до '.$this->age_max.' лет, ';
	}

	// Ref
	if ($this->ref_min && $this->ref_max) {
	    $res .= $this->ref_min.' - '.$this->ref_max.' ';
	} else if ($this->ref_min) {
	    $res .= ' > '.$this->ref_min.' ';
	} else if ($this->ref_max) {
	    $res .= ' < '.$this->ref_max.' ';
	}
	
	
	// Ед. изм.
	$res .= $units;

	return $res;
    }
}




