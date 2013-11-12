<?php

namespace model;

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

	private $image;

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
			$this->errors[] = "A title is required.";
		}
		else if(strlen($developer) > 50) {
			$this->errors[] = "The title can't consist of more than 50 characters.";
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
			$this->errors[] = "A developer is required.";
		}
		else if(strlen($developer) > 50) {
			$this->errors[] = "The developer can't consist of more than 50 characters.";
		}
		$this->developer = $developer;
	}

	// @return string
	public function getDeveloper() {
		return $this->developer;
	}

	// @param string $releaseDate
	public function setReleaseDate($releaseDate) {
		if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $releaseDate)) {
			$this->errors[] = "Invalid date form. Must be of type yyyy-mm-dd.";
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

	public function setImage($image, $size = null) {
		$extensions =  array('gif', 'png', 'jpg', 'jpeg');
		$extension = pathinfo($image, PATHINFO_EXTENSION);
		
		if(!in_array($extension, $extensions)) {
			$this->errors[] = "Invalid file. Only gif, png, jpg and jpeg are allowed.";
		}
		else if(file_exists("images/$image")) {
			$this->errors[] = "$image already exists.";
		}
		else if($size / 1024 > 35) {
			$this->errors[] = "The file size can't be more than 35 kB.";
		}

		$this->image = $image;
	}

	public function getImage() {
		return $this->image;
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