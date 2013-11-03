<?php

class Game {
	// @var int $gameId
	private $gameId;

	// @var string $title
	private $title;

	// @var string $developer
	private $developer;

	// @var string $releaseDate
	private $releaseDate;

	// @var string $category
	private $category;

	// @var string $consoleId
	private $consoleId;

	// @var array of strings $errors
	// Innehåller valideringsfel
	private $errors;

	public function Game() {
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
	public function setGameId($gameId) {
		$this->gameId = $gameId;
	}

	// @return int
	public function getGameId() {
		return $this->gameId;
	}

	// @param string $title
	public function setTitle($title) {
		if(empty($title)) {
			$this->errors[] = "En titel måste anges.";
		}
		$this->title = $title;
	}

	// @return string
	public function getTitle() {
		return $this->title;
	}

	// @param string $developer
	public function setDeveloper($developer) {
		if(empty($developer)) {
			$this->errors[] = "En utvecklare måste anges.";
		}
		$this->developer = $developer;
	}

	// @return string
	public function getDeveloper() {
		return $this->developer;
	}

	// @param string $releaseDate
	public function setReleaseDate($releaseDate) {
		if(empty($releaseDate)) {
			$this->errors[] = "Ett lanseringsdatum måste anges.";
		}
		$this->releaseDate = $releaseDate;
	}

	// @return string
	public function getReleaseDate() {
		return $this->releaseDate;
	}

	// @param string $category
	public function setCategory($category) {
		$this->category = $category;
	}

	// @return string
	public function getCategory() {
		return $this->category;
	}

	// @param int $consoleId
	public function setConsoleId($consoleId) {
		$this->consoleId = $consoleId;
	}

	// @return int
	public function getConsoleId() {
		return $this->consoleId;
	}
}