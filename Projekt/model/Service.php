<?php

namespace model;

class Service {

	// Console 

	// @var ConsoleDAL $consoleDAL
	private $consoleDAL;

	// @return ConsoleDAL $consoleDAL
	public function getConsoleDAL() {
		if(isset($this->consoleDAL)) {
			return $this->consoleDAL;
		}
		else {
			return new \ConsoleDAL();
		}
	}

	// @return array of Console objects
	public function getConsoles() {
		return $this->getConsoleDAL()->getConsoles();
	}

	// @return Console
	public function getConsole($consoleId) {
		return $this->getConsoleDAL()->getConsole($consoleId);
	}

	// @param int $consoleId
	public function deleteConsole($consoleId) {
		$this->getConsoleDAL()->deleteConsole($consoleId);
	}

	// @param Console $console
	public function saveConsole(\model\Console $console) {
		$this->getConsoleDAL()->saveConsole($console);
	}

	// Game

	// @var GameDAL $gameDAL
	private $gameDAL;

	// @return GameDAL $gameDAL
	public function getGameDAL() {
		if(isset($this->gameDAL)) {
			return $this->gameDAL;
		}
		else {
			return new \GameDAL();
		}
	}

	// @return array of Game objects
	public function getGames($consoleId) {
		return $this->getGameDAL()->getGames($consoleId);
	}

	// @return Game 
	public function getGame($gameId) {
		return $this->getGameDAL()->getGame($gameId);
	}

	// @param Game $game
	public function saveGame(\model\Game $game) {
		$this->getGameDAL()->saveGame($game);
	}

	// @param int $gameId
	// @param int $consoleId
	public function deleteGame($gameId, $consoleId) {
		$this->getGameDAL()->deleteGame($gameId, $consoleId);
	}

	// @return array of Game objects
	public function searchGame(\model\Game $game) {
		return $this->getGameDAL()->searchGame($game);
	}

	// User

	// @var UserDAL $userDAL
	private $userDAL;

	// @return UserDAL
	public function getUserDAL() {
		if(isset($this->userDAL)) {
			return $this->userDAL;
		}
		else {
			return new \UserDAL();
		}
	}

	// @return User
	public function findUser($username, $password) {
		return $this->getUserDAL()->findUser($username, $password);
	}
}