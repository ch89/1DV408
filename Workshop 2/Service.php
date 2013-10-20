<?php

class Service {

	// Member

	private $memberDAL;

	public function getMemberDAL() {
		if(isset($this->memberDAL)) {
			return $this->memberDAL;
		}
		else {
			return new MemberDAL();
		}
	}

	public function getMembers() {
		return $this->getMemberDAL()->getMembers();
	}

	public function getMember($memberID) {
		return $this->getMemberDAL()->getMember($memberID);
	}

	public function addMember(Member $member) {
		$this->getMemberDAL()->addMember($member);
	}

	public function updateMember(Member $member) {
		$this->getMemberDAL()->updateMember($member);
	}

	public function deleteMember($memberID) {
		$this->getMemberDAL()->deleteMember($memberID);
	}



	// Boat

	private $boatDAL;

	public function getBoatDAL() {
		if(isset($this->boatDAL)) {
			return $this->boatDAL;
		}
		else {
			return new BoatDAL();
		}
	}

	public function getBoats($memberID) {
		return $this->getBoatDAL()->getBoats($memberID);
	}

	public function addBoat(Boat $boat) {
		$this->getBoatDAL()->addBoat($boat);
	}

	public function updateBoat(Boat $boat) {
		$this->getBoatDAL()->updateBoat($boat);
	}

	public function deleteBoat($boatID, $memberID) {
		$this->getBoatDAL()->deleteBoat($boatID, $memberID);
	}
}