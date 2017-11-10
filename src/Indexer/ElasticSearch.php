<?php

namespace MSHACK\DataScraper\Indexer;

use Guzzle\Http\Client;
use MSHACK\DataScraper\GeoData\Entry;

class ElasticSearch {
	protected $url = "https://elasticsearch.codeformuenster.org/stadtteil_events/event";

	/**
	 * Indexes the given geo object to the elastic search index
	 * @param Entry $entry
	 */
	public function transferToIndex($entry){
		$guzzle = new Client();
		$request = $guzzle->post($this->url,
		[
			'content-type' => 'application/json'
		]);
		$request->setBody(json_encode($entry));
		$request->send();
	}
}