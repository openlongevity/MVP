<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Log;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\TransferStats;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Exceptions\EmptyCollectionException;

use App\Marker;

class UtilsController extends Controller
{
    private $helixUrl = "http://www.helix.ru/";
    /**
     * Parse page with list of markers by helix lab.
     *
     * @return \Illuminate\Http\Response
     */
    public function parseHelix(Request $request)
    {
	// Get data from server.
        $client = new Client();
        $res = $client->get($this->helixUrl."kb");
        $sHtml = (string)$res->getBody();

        // Parse HTML.
        $dom = new Dom;
        $dom->load($sHtml);

	$aLinks = array();
	foreach($dom->find('.Kb-Sections-Item') as $row) {
	    $aLinks[] = $row->getAttribute('href');
	    $oMarker = new Marker();
	    $oMarker->link = $row->getAttribute('href');
	    $oMarker->Save();
	}
	return response()->json(array('result' => 'ok', 'links' => $aLinks));
    }   
    
    /**
     * Parse page with some marker.
     *
     * @return \Illuminate\Http\Response
     */
    public function parseHelixMarker(Request $request)
    {
	$id = $request->id;
	$oMarker = Marker::where('id', $id)->first();
	if (!$oMarker) {
	    return response()->json(array('error' => 1));
	}

	// Get data from server.
        $client = new Client();
        $res = $client->get($this->helixUrl.$oMarker->link);
        $sHtml = (string)$res->getBody();

        // Parse HTML.
        $dom = new Dom;
        $dom->load($sHtml);

	$aPs = $dom->find('.Kb-Content-Item-Content')->find('p');
	$oMarker->desc_short = $aPs[0]->innerHtml;

	$aTags = array(
	    'names' => '#subj2',
	    'names_en' => '#subj3',
	    'method' => '#subj4',
	    'units' => '#subj5',
	    'biomaterial' => '#subj6',
	    'preparing' => '#subj7',
	    'desc' => '#subj9',
	);

	foreach($aTags as $key => $tag) {
	    try {
		$oMarker->{$key} = $dom->find($tag)->getParent()->nextSibling()->nextSibling()->innerHtml;	
	    } catch (EmptyCollectionException $e) {
	    }
	}

	$oMarker->Save();

	return response()->json(array('result' => $oMarker));
    }   
    
    
    /**
     * Add name for marker.
     *
     * @return \Illuminate\Http\Response
     */
    public function parseHelixAddName(Request $request) {
	$id = $request->id;
	$oMarker = Marker::where('id', $id)->first();
	if (!$oMarker) {
	    return response()->json(array('error' => 1));
	}

	// Get data from server.
        $client = new Client();
        $res = $client->get($this->helixUrl.$oMarker->link);
        $sHtml = (string)$res->getBody();

        // Parse HTML.
        $dom = new Dom;
        $dom->load($sHtml);

	$oMarker->name = $dom->find('.Kb-Content-Item-Title')->text;	

	$oMarker->Save();

	return response()->json(array('result' => $oMarker->name));
    }   
    
}
