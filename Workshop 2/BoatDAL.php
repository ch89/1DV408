<?php

class BoatDAL extends DALBase {

	// @param string $sql
	// @param int $id
	// @return array of games
	public function getAllBoats($sql, $id) {
		$stmt = $this->getMysqli()->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->bind_result($boatId, $type, $length, $memberId);
		$boats = array();

		while($stmt->fetch()) {
			$boat = new Boat();
			$boat->setBoatId($boatId);
			$boat->setType($type);
			$boat->setLength($length);
			$boat->setMemberId($memberId);
			$boats[] = $boat;
		}

		return $boats;
	}

	// @param int $memberId
	// @return array of Boat objects
	public function getBoats($memberId) {
		$sql = "SELECT * FROM Boat WHERE memberId = ?;";
		return $this->getAllBoats($sql, $memberId);
	}

	// @param int $memberId
	// @return Boat
	// @throw Exception
	// Finns det inte en båt med det angivna id't så kastas ett undantag
	public function getBoat($boatId) {
		$sql = "SELECT * FROM Boat WHERE boatId = ?;";
		$boats = $this->getAllBoats($sql, $boatId);

		if(count($boats) == 1) {
			return $boats[0];
		}

		throw new Exception("No result.");
	}

	// @param Boat $boat
	// har båtobjektet ett id så finns det redan och ska därmed uppdateras,
	// annars ska det skapas ett nytt båtobjekt
	public function saveBoat(Boat $boat) {
		$type = $boat->getType();
		$length = $boat->getLength();

		if($boat->getBoatId()) {
			$boatId = $boat->getBoatId();
			$sql = "UPDATE Boat SET type = ?, length = ? WHERE boatId = ?;";
			$stmt = $this->getMysqli()->prepare($sql);
			$stmt->bind_param("sii", $type, $length, $boatId);
		}
		else {
			$memberId = $boat->getMemberId();
			$this->updateNumberOfBoats($memberId, 1);
			$sql = "INSERT INTO Boat(type, length, memberId) VALUES(?, ?, ?);";
			$stmt = $this->getMysqli()->prepare($sql);
			$stmt->bind_param("sii", $type, $length, $memberId);
		}

		$stmt->execute();
	}

	// @param int $boatId
	// @param int $memberId
	public function deleteBoat($boatId, $memberId) {
		$sql = "DELETE FROM Boat WHERE boatId = ?;";
		$this->baseDelete($sql, $boatId, $memberId);
	}
}