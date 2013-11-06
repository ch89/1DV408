<?php

class Boat {
	// @var int $boatId
	private $boatId;

	// @var string $type
	private $type;

	// @var string $length
	private $length;

	// @var string $memberId
	private $memberId;

	// @var array of strings $errors
	// Innehåller valideringsfel
	private $errors;

	public function Boat() {
		$this->errors = array();
	}

	// @return bool
	public function hasErrors() {
		return count($this->errors) > 0;
	}

	// @return array of strings
	public function getErrors() {
		return $this->errors;
	}

	// @param int $gameId
	public function setBoatId($boatId) {
		$this->boatId = $boatId;
	}

	// @return int
	public function getBoatId() {
		return $this->boatId;
	}

	// @param string $type
	public function setType($type) {
		$this->type = $type;
	}

	// @return string
	public function getType() {
		return $this->type;
	}

	// @param string $length
	public function setLength($length) {
		if(empty($length)) {
			$this->errors[] = "A length is required.";
		}
		else if(!is_numeric($length)) {
			$this->errors[] = "The length must be a number.";
		}
		else if($length > 10) {
			$this->errors[] = "The length can't be more than 10 meters.";
		}
		$this->length = $length;
	}

	// @return string
	public function getLength() {
		return $this->length;
	}

	// @param int $memberId
	public function setMemberId($memberId) {
		$this->memberId = $memberId;
	}

	// @return int
	public function getMemberId() {
		return $this->memberId;
	}
}