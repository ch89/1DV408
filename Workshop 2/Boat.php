<?php

class Boat {
	private $boatID;
	private $type;
	private $length;
	private $memberID;
	private $errors;

	public function Boat($type, $length) {
		$this->errors = array();
		$this->type = $type;
		$this->setLength($length);
	}

	public function hasErrors() {
		return count($this->errors) > 0;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function setBoatID($boatID) {
		$this->boatID = $boatID;
	}

	public function setLength($length) {
		if(!is_numeric($length)) {
			$this->errors[] = "Båtens längd måste anges.";
		}
		$this->length = $length;
	}

	public function setMemberID($memberID) {
		$this->memberID = $memberID;
	}

	public function getBoatID() {
		return $this->boatID;
	}

	public function getType() {
		return $this->type;
	}

	public function getLength() {
		return $this->length;
	}

	public function getMemberID() {
		return $this->memberID;
	}
}