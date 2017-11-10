<?php
namespace MSHACK\DataScraper\GeoData;

class Entry {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $url;

	/**
	 * @var Address
	 */
	public $address;

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * @return Address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @param Address $address
	 */
	public function setAddress($address) {
		$this->address = $address;
	}
}
