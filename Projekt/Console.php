<?php

class Console {
	// @var int $consoleId
	private $consoleId;

	// @var string $name
	private $name;

	// @var string $developer
	private $developer;

	// @var string $releaseDate
	private $releaseDate;

	// @var int $numberOfGames
	private $numberOfGames;

	// @var array of strings $errors
	// Innehåller valideringsfel
	private $errors;

	public function Console() {
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

	// @param int $consoleId
	public function setConsoleId($consoleId) {
		$this->consoleId = $consoleId;
	}

	// @return string
	public function getConsoleId() {
		return $this->consoleId;
	}

	// @param string $name
	public function setName($name) {
		if(empty($name)) {
			$this->errors[] = "Ett namn måste anges.";
		}
		else if(strlen($name) > 50) {
			$this->errors[] = "Namnet kan inte bestå av mer än 50 tecken.";
		}
		$this->name = $name;
	}

	// @return string
	public function getName() {
		return $this->name;
	}

	// @param string $developer
	public function setDeveloper($developer) {
		if(empty($developer)) {
			$this->errors[] = "En utvecklare måste anges.";
		}
		else if(strlen($developer) > 50) {
			$this->errors[] = "Utvecklaren kan inte bestå av mer än 50 tecken.";
		}
		$this->developer = $developer;
	}

	// @return string
	public function getDeveloper() {
		return $this->developer;
	}

	// @param string $releaseDate
	public function setReleaseDate($releaseDate) {
		if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $releaseDate)){
			$this->errors[] = "Ett giltigt datum måste anges.";
		}
		$this->releaseDate = $releaseDate;
	}

	// @return string
	public function getReleaseDate() {
		return $this->releaseDate;
	}

	// @param int $numberOfGames
	public function setNumberOfGames($numberOfGames) {
		$this->numberOfGames = $numberOfGames;
	}

	// @return int
	public function getNumberOfGames() {
		return $this->numberOfGames;
	}
}