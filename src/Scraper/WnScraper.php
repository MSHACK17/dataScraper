<?php
namespace MSHACK\DataScraper\Scraper;

use MSHACK\DataScraper\Dto\WnEvent;
use MSHACK\DataScraper\Services\GeoCoder;

class WnScraper {
	protected $baseUrl = "http://termine.wn.de/suche/?query=new&ort=M%C3%BCnster&details_open=&suchtext=&categories[]=-1&day_from=10&month_from=11&year_from=2017&day_to=10&month_to=11&year_to=2017";


	protected function fetchContent ($url){
		$httpClient = new \Guzzle\Http\Client();
		$request = $httpClient->get($url);
		$response = $request->send();
		$htmlContent = $response->getBody(true);
		return $htmlContent;
	}

	protected function getDetailUrlForEventId($eventId){
		$currentDate = new \DateTime();
		$url = "http://termine.wn.de/termin/?termin_id=$eventId&datum=".$currentDate->format("d.m.Y");
		return $url;
	}

	protected function extractDetailContent($content){
		$matches = [];
		$regex = "/Veranstaltung:(?s)(.*)Telefon:/";
		if (preg_match($regex, $content, $matches)){
			$detailContent = $matches[0];
			$plainDetailContent = \Html2Text\Html2Text::convert($detailContent, TRUE);
			return $plainDetailContent;
		}else{
			Throw new \Exception("Unknown format");
		}
	}

	protected function getObjectFromDetailContent($detailHtml){
		$wnEvent = new WnEvent();

		$name = trim($this->getRegexResult($detailHtml, '/Veranstaltung:(.*)/'));
		$date = trim($this->getRegexResult($detailHtml, '/Datum:.*(\d\d\.\d\d.\d\d\d\d)/'));
		$category = trim($this->getRegexResult($detailHtml, '/Rubrik:(.*)/'));
		$address = trim($this->getRegexResult($detailHtml, '/Location:(?s)(.*)Telefon:/'));
		$district = trim($this->getRegexResult($detailHtml, '/Ort:(.*)/'));

		$wnEvent->setName($name);
		$wnEvent->setDate(\DateTime::createFromFormat('d.m.Y', $date));
		$wnEvent->setCategory($category);
		$wnEvent->setAddress($address);
		$wnEvent->setDistrict($district);
		return $wnEvent;
	}

	protected function getRegexResult($content, $regex){
		$matches = [];
		if (preg_match($regex, $content, $matches)){
			return $matches[1];
		}else{
			return "";
		}
	}

	public function getData(){
		$count= 0;
		$allObjects = [];
		$content = $this->fetchContent($this->baseUrl);
		$eventIds = $this->getEventIdsFromContent($content);

		foreach ($eventIds as $eventId){
			try {
				$detailUrl = $this->getDetailUrlForEventId($eventId);
				$detailContent = $this->fetchContent($detailUrl);
				$detailHtml = $this->extractDetailContent($detailContent);

				$wnEvent = $this->getObjectFromDetailContent($detailHtml);
				$wnEvent->setUrl($detailUrl);
				$allObjects[] = $wnEvent;
				$count++;

				if ($count > 2){
					$this->initializeGeoCoordinates($allObjects);
					return $allObjects;
				}
			}catch (\Exception $ex){
				//TODO:
			}
		}
	}

	/**
	 * @param WnEvent[] $wnEvents
	 */
	protected function initializeGeoCoordinates(&$wnEvents){
		$geoCoder = new GeoCoder();
		/** @var WnEvent $event */
		foreach ($wnEvents as &$event){
			$coordinates = $geoCoder->getCoordinates($event->getAddress());
			$event->setCoordinates($coordinates);
		}
	}


	protected function getEventIdsFromContent($content){
		$matches = [];
		$regex = "/termin_id=(\\d+)/";
		if (preg_match_all($regex, $content, $matches)){
			return $matches[1];
		}else{
			Throw new \Exception("No event IDs found");
		}
	}
}