<?php

class MemberDAL extends DALBase {

	// @return array av Member objects
	// om $memberId är null så returneras samtliga medlemmar annars
	// returneras medlemmen med det id't
	public function getAllMembers($sql, $memberId = null) {
		$stmt = $this->getMysqli()->prepare($sql);

		if($memberId) {
			$stmt->bind_param("i", $memberId);
		}

		$stmt->execute();
		$stmt->bind_result($memberId, $name, $socialSecurityNumber, $numberOfBoats);
		$members = array();
		
		while($stmt->fetch()) {
			$member = new Member();
			$member->setMemberId($memberId);
			$member->setName($name);
			$member->setSocialSecurityNumber($socialSecurityNumber);
			$member->setNumberOfBoats($numberOfBoats);
			$members[] = $member;
		}

		return $members;
	}

	// @return array av Member objects
	public function getMembers() {
		$sql = "SELECT * FROM Member;";
		return $this->getAllMembers($sql);
	}

	// @return Member
	// @throw Exception 
	// Kastar ett undantag om det inte finns en medlem med det angivna id't
	public function getMember($memberId) {
		$sql = "SELECT * FROM Member WHERE memberId = ?;";
		$members = $this->getAllMembers($sql, $memberId);

		if(count($members) == 1) {
			return $members[0];
		}
		throw new Exception("Couldn't find a member with the ID $memberId.");
	}

	// @param Member $member
	// Har medlemmen ett ID så finns den redan och ska uppdateras, 
	// annars ska det skapas en ny medlem
	public function saveMember(Member $member) {
		$name = $member->getName();
		$socialSecurityNumber = $member->getSocialSecurityNumber();
		//$numberOfBoats = $member->getNumberOfBoats();

		if($member->getMemberId()) {
			$memberId = $member->getMemberId();
			$sql = "UPDATE Member SET name = ?, socialSecurityNumber = ? WHERE memberId = ?;";
			$stmt = $this->getMysqli()->prepare($sql);
			$stmt->bind_param("ssi", $name, $socialSecurityNumber, $memberId);
		}
		else {
			$sql = "INSERT INTO Member(name, socialSecurityNumber) VALUES(?, ?);";
			$stmt = $this->getMysqli()->prepare($sql);
			$stmt->bind_param("ss", $name, $socialSecurityNumber);
		}
		$stmt->execute();
	}

	// @param int $memberId
	// Tar bort en medlem med det angivna id't
	public function deleteMember($memberId) {
		$sql = "DELETE FROM Member WHERE memberId = ?;";
		$this->baseDelete($sql, $memberId);
	}
}