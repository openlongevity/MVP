<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class Helper
{
    /**
     * Updates API log into database. 
     */
    public static function getPluralForm($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	return $after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
    }
}
