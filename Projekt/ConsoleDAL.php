<?php

class ConsoleDAL extends DALBase {

	// @return array av Console objects
	// om $consoleId är null så returneras samtliga konsoler annars
	// returneras konsolen med det id't
	public function getAllConsoles($sql, $consoleId = null) {
		$stmt = $this->getMysqli()->prepare($sql);

		if($consoleId) {
			$stmt->bind_param("i", $consoleId);
		}

		$stmt->execute();
		$stmt->bind_result($consoleId, $name, $developer, $releaseDate, $numberOfGames);
		$consoles = array();
		
		while($stmt->fetch()) {
			$console = new Console();
			$console->setConsoleId($consoleId);
			$console->setName($name);
			$console->setDeveloper($developer);
			$console->setReleaseDate($releaseDate);
			$console->setNumberOfGames($numberOfGames);
			$consoles[] = $console;
		}

		return $consoles;
	}

	// @return array av Console objects
	public function getConsoles() {
		$sql = "SELECT * FROM Console;";
		return $this->getAllConsoles($sql);
	}

	// @return Console
	// @throw Exception 
	// Kastar ett undantag om det inte finns en konsol med det angivna id't
	public function getConsole($consoleId) {
		$sql = "SELECT * FROM Console WHERE consoleId = ?;";
		$consoles = $this->getAllConsoles($sql, $consoleId);

		if(count($consoles) == 1) {
			return $consoles[0];
		}
		throw new Exception("Couldn't find a console with the ID $consoleId.");
	}

	// @param Console $console
	// Har konsolen ett ID så finns den redan och ska uppdateras, 
	// annars ska det skapas en ny konsol
	public function saveConsole(Console $console) {
		$name = $console->getName();
		$developer = $console->getDeveloper();
		$releaseDate = $console->getReleaseDate();

		if($console->getConsoleId()) {
			$consoleId = $console->getConsoleId();
			$sql = "UPDATE Console SET name = ?, developer = ?, releaseDate = ? WHERE consoleId = ?;";
			$stmt = $this->getMysqli()->prepare($sql);
			$stmt->bind_param("sssi", $name, $developer, $releaseDate, $consoleId);
		}
		else {
			$sql = "INSERT INTO Console(name, developer, releaseDate) VALUES(?, ?, ?);";
			$stmt = $this->getMysqli()->prepare($sql);
			$stmt->bind_param("sss", $name, $developer, $releaseDate);
		}
		$stmt->execute();
	}

	// @param int $consoleId
	// Tar bort en konsol med det angivna id't
	public function deleteConsole($consoleId) {
		$sql = "DELETE FROM Console WHERE consoleId = ?;";
		$this->baseDelete($sql, $consoleId);
	}
}