<?php

class Member {
	private $memberID;
	private $name;
	private $socialSecurityNumber;
	private $numberOfBoats;
	public $errors;

	public function Member($name, $socialSecurityNumber) {
		$this->errors = array();
		$this->setName($name);
		$this->setSocialSecurityNumber($socialSecurityNumber);
	}

	public function hasErrors() {
		return count($this->errors) > 0;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function setMemberID($memberID) {
		$this->memberID = $memberID;
	}

	public function setName($name) {
		if(empty($name)) {
			$this->errors[] = "Ett namn måste anges.";
		}
		else if(strlen($name) > 30) {
			$this->errors[] = "Namnet får inte bestå av mer än 30 tecken.";
		}
		else if($name != strip_tags($name)) {
			$this->errors[] = "Namnet innehåller ogiltiga tecken.";
		}			
		$this->name = $name;
	}

	public function setSocialSecurityNumber($socialSecurityNumber) {
		if(!preg_match("/\d{6}\-\d{4}/", $socialSecurityNumber)) {
			$this->errors[] = "Ogiltigt personnummer.";
		}
		$this->socialSecurityNumber = $socialSecurityNumber;
	}

	public function setNumberOfBoats($numberOfBoats) {
		$this->numberOfBoats = $numberOfBoats;
	}

	public function getMemberID() {
		return $this->memberID;
	}

	public function getName() {
		return $this->name;
	}

	public function getSocialSecurityNumber() {
		return $this->socialSecurityNumber;
	}

	public function getNumberOfBoats() {
		return $this->numberOfBoats;
	}
}