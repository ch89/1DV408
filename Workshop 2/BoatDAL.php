<?php

class BoatDAL {
	private static $memberTable = "Member";
	private static $table = "Boat";
	private $mysqli;

	public function BoatDAL() {
		$this->mysqli = new mysqli("localhost", "root", "smultron3", "memberregister");
	}

	public function addBoat(Boat $boat) {
		$query = "INSERT INTO " . self::$table . "(Type, Length, MemberID) VALUES(?, ?, ?)";

		$type = $boat->getType();
		$length = $boat->getLength();
		$memberID = $boat->getMemberID();

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("sii", $type, $length, $memberID);
		$statement->execute();

		$query = "UPDATE " . self::$memberTable . " SET NumberOfBoats = NumberOfBoats + 1 WHERE MemberID = ?;";

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("i", $memberID);
		$statement->execute();
	}

	public function getBoats($memberID) {
		$boats = array();

		$query = "SELECT BoatID, Type, Length, MemberID FROM " . self::$table . " WHERE MemberID = ?;";

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("i", $memberID);
		$statement->execute();

		$statement->bind_result($boatID, $type, $length, $memberID);

		while($statement->fetch()) {
			$boat = new Boat($type, $length, $memberID);
			$boat->setBoatID($boatID);
			$boat->setMemberID($memberID);
			$boats[] = $boat;
		}

		return $boats;
	}

	public function updateBoat(Boat $boat) {
		$boatID = $boat->getBoatID();
		$type = $boat->getType();
		$length = $boat->getLength();

		$query = "UPDATE " . self::$table . " SET Type = ?, Length = ? WHERE BoatID = ?;";

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("sii", $type, $length, $boatID);
		$statement->execute();
	}

	public function deleteBoat($boatID, $memberID) {
		$query = "DELETE FROM " . self::$table . " WHERE BoatID = ?;";
		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("i", $boatID);
		$statement->execute();

		$query = "UPDATE " . self::$memberTable . " SET NumberOfBoats = NumberOfBoats - 1 WHERE MemberID = ?;";

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("i", $memberID);
		$statement->execute();
	}
}