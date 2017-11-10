<?php
namespace MSHACK\DataScraper\GeoData;

class Entry {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var []
	 */
	public $tags;

	/**
	 * @var string
	 */
	public $url;

	/**
	 * @var Address
	 */
	public $address;

	/**
	 * @var string
	 */
	public $date_start;

	/**
	 * @var string
	 */
	public $date_end;


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

	/**
	 * @return mixed
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * @param [] $types
	 */
	public function setTags($types) {
		$this->tags = $types;
	}

	/**
	 * @param $type
	 */
	public function addTag($type){
		$this->tags[] = $type;
	}

	/**
	 * @return string
	 */
	public function getDateStart() {
		return $this->date_start;
	}

	/**
	 * @param string $date_start
	 */
	public function setDateStart($date_start) {
		$this->date_start = $date_start;
	}

	/**
	 * @return string
	 */
	public function getDateEnd() {
		return $this->date_end;
	}

	/**
	 * @param string $date_end
	 */
	public function setDateEnd($date_end) {
		$this->date_end = $date_end;
	}
}
