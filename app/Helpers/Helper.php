<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\PanelMarkerReference;

class Helper
{
    /**
     * Returns plural from for number. 
     */
    public static function getPluralForm($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	return $after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
    }
    
    /**
     * Returns list of references for marker. 
     */
    public static function getRefs($marker_id, $panel_id) {
	$qGetRefs = PanelMarkerReference::where('marker_id', $marker_id);
	if ($panel_id) {
	    $qGetRefs = $qGetRefs->where('panel_id', $panel_id);
	} else {
	    $qGetRefs = $qGetRefs->whereNull('panel_id');
	}

	return $qGetRefs->get();
    }
}
