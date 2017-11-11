<?php
namespace MSHACK\DataScraper\Scraper;

use MSHACK\DataScraper\Dto\Club;
use MSHACK\DataScraper\Dto\WnNews;
use MSHACK\DataScraper\Services\GeoCoder;
use SimplePie;
use SimplePie_Item;

class SkubisScraper extends BaseScraper {
	protected $feedUrl = "http://www.wn.de/rss/feed/wn_muenster";
	protected $debug = TRUE;

	public function getData(){
		$clubs = [];
		$xml = file_get_contents("/share/opendata/skubis-organisations.xml");

		$service = new \Sabre\Xml\Service();
		$service->elementMap = [
			'{}Organisation' => function(\Sabre\Xml\Reader $reader) {
				return \Sabre\Xml\Deserializer\keyValue($reader);
			}
		];

		$result = $service->parse($xml);

		foreach ($result as $organisation){
			$organisationData = $organisation["value"];
			$organisationName = $organisationData['{}Name'];
			if (!is_null($organisationName)){

				$club = new Club();
				$club->setName($organisationName);

				$geoCoder = new GeoCoder();
				$geoResult = $geoCoder->getCoordinates($organisationName.", Münster");

				if (!is_null($geoResult)){
					$club->setZip($geoResult->getPostalCode());
					$club->setStreet($geoResult->getStreetName()." ".$geoResult->getStreetNumber());
					$club->setCity($geoResult->getLocality());
					$club->setDistrict($geoResult->getSubLocality());
					$club->setCoordinates($geoResult->getCoordinates());

					$clubs[] = $club;
				}
			}
		}
		return $clubs;
	}
}