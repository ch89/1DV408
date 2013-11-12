<?php

namespace model;

class DALBase {
	// @var mysqli $mysqli
	private $mysqli;

	public function DALBase() {
		$this->mysqli = new mysqli("localhost", "root", "", "console");
	}

	// @return mysqli
	protected function getMysqli() {
		return $this->mysqli;
	}

	// @param string $sql
	// @param int $id
	// @param int $consoleId
	// Gemensam delete-metod för alla DAL-klasser
	public function baseDelete($sql, $id, $consoleId = null) {
		$stmt = $this->getMysqli()->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		if($consoleId) {
			$this->updateNumberOfGames($consoleId, -1);
		}
	}

	// @param int $consoleId
	// @param int $value
	// Uppdaterar antalet registrerade spel för en konsol
	public function updateNumberOfGames($consoleId, $value) {
		$sql = "UPDATE Console SET numberOfGames = numberOfGames + $value WHERE consoleId = ?;";
		$stmt = $this->getMysqli()->prepare($sql);
		$stmt->bind_param("i", $consoleId);
		$stmt->execute();
	}
}