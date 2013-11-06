<?php

class Member {
	// @var int $memberId
	private $memberId;

	// @var string $name
	private $name;

	// @var string $socialSecurityNumber
	private $socialSecurityNumber;

	// @var int $numberOfBoats
	private $numberOfBoats;

	// @var array of strings $errors
	// Innehåller valideringsfel
	private $errors;

	public function Member() {
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

	// @param int $memberId
	public function setMemberId($memberId) {
		$this->memberId = $memberId;
	}

	// @return string
	public function getMemberId() {
		return $this->memberId;
	}

	// @param string $name
	public function setName($name) {
		if(empty($name)) {
			$this->errors[] = "A name is required.";
		}
		else if(strlen($name) > 50) {
			$this->errors[] = "The name can't consist of more than 50 characters.";
		}
		$this->name = $name;
	}

	// @return string
	public function getName() {
		return $this->name;
	}

	// @param string $socialSecurityNumber
	public function setSocialSecurityNumber($socialSecurityNumber) {
		if(!preg_match("/\d{6}\-\d{4}/", $socialSecurityNumber)) {
			$this->errors[] = "Invalid social security number form.";
		}
		$this->socialSecurityNumber = $socialSecurityNumber;
	}

	// @return string
	public function getSocialSecurityNumber() {
		return $this->socialSecurityNumber;
	}

	// @param int $numberOfBoats
	public function setNumberOfBoats($numberOfBoats) {
		$this->numberOfBoats = $numberOfBoats;
	}

	// @return int
	public function getNumberOfBoats() {
		return $this->numberOfBoats;
	}
}