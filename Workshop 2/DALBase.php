<?php

class DALBase {
	// @var mysqli $mysqli
	private $mysqli;

	public function DALBase() {
		$this->mysqli = new mysqli("localhost", "root", "", "member");
	}

	// @return mysqli
	protected function getMysqli() {
		return $this->mysqli;
	}

	// @param string $sql
	// @param int $id
	// @param int $memberId
	// Gemensam delete-metod för alla DAL-klasser
	public function baseDelete($sql, $id, $memberId = null) {
		$stmt = $this->getMysqli()->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		if($memberId) {
			$this->updateNumberOfBoats($memberId, -1);
		}
	}

	// @param int $memberId
	// @param int $value
	// Uppdaterar antalet registrerade båtar för en medlem
	public function updateNumberOfBoats($memberId, $value) {
		$sql = "UPDATE Member SET numberOfBoats = numberOfBoats + $value WHERE memberId = ?;";
		$stmt = $this->getMysqli()->prepare($sql);
		$stmt->bind_param("i", $memberId);
		$stmt->execute();
	}
}