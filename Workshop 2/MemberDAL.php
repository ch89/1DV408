<?php

class MemberDAL {
	private static $table = "Member";
	private $mysqli;

	public function MemberDAL() {
		$this->mysqli = new mysqli("localhost", "root", "", "member");
	}

	public function addMember(Member $member) {
		$query = "INSERT INTO " . self::$table . "(Name, SocialSecurityNumber) VALUES(?, ?)";

		$name = $member->getName();
		$socialSecurityNumber = $member->getSocialSecurityNumber();

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("ss", $name, $socialSecurityNumber);
		$statement->execute();
	}

	public function getMembers() {
		$members = array();

		$query = "SELECT MemberID, Name, SocialSecurityNumber, NumberOfBoats FROM " . self::$table . ";";
		$statement = $this->mysqli->prepare($query);
		$statement->execute();

		$statement->bind_result($memberID, $name, $socialSecurityNumber, $numberOfBoats);

		while($statement->fetch()) {
			$member = new Member($name, $socialSecurityNumber);
			$member->setMemberID($memberID);
			$member->setNumberOfBoats($numberOfBoats);
			$members[] = $member;
		}

		return $members;
	}

	public function getMember($memberID) {
		$query = "SELECT * FROM " . self::$table . " WHERE MemberID = ?;";

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("i", $memberID);
		$statement->execute();

		$statement->bind_result($memberID, $name, $socialSecurityNumber, $numberOfBoats);

		$statement->fetch();
		$member = new Member($name, $socialSecurityNumber);
		$member->setMemberID($memberID);
		$member->setNumberOfBoats($numberOfBoats);
		return $member;
	}

	public function updateMember(Member $member) {
		$memberID = $member->getMemberID();
		$name = $member->getName();
		$socialSecurityNumber = $member->getSocialSecurityNumber();

		$query = "UPDATE " . self::$table . " SET Name = ?, SocialSecurityNumber = ? WHERE MemberID = ?;";

		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("ssi", $name, $socialSecurityNumber, $memberID);
		$statement->execute();
	}

	public function deleteMember($memberID) {
		$query = "DELETE FROM " . self::$table . " WHERE MemberID = ?;";
		$statement = $this->mysqli->prepare($query);
		$statement->bind_param("i", $memberID);
		$statement->execute();
	}
}




public function getGames($consoleId) {
	$query = "SELECT * FROM Game WHERE consoleId = ?;";

	$stmt = $this->mysqli->prepare($query);
	$stmt->bind_param("i", $consoleId);

	if(!$stmt->execute()) {
		throw new Exception("Kunde inte hitta posten");
	}

	$stmt->bind_result($gameId, $title, $developer, $consoleId);

	$games = array();
	while($stmt->fetch()) {
		$game = new Game();
		$game->setGameId($gameId);
		$game->setTitle($title);
		$game->setDeveloper($developer);
		$games[] = $game;
	}

	return $games;
}

if($stmt->fetch()) {
	return new Console($consoleId, $name, $developer);
}

throw new Exception();


try {
	$this->service->getConsoleById($_GET["id"]);
}
catch() {
	header("Location: index.php");
}