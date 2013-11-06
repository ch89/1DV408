<?php

class Service {

	// Console 

	// @var ConsoleDAL $memberDAL
	private $memberDAL;

	// @return ConsoleDAL $memberDAL
	public function getMemberDAL() {
		if(isset($this->memberDAL)) {
			return $this->memberDAL;
		}
		else {
			return new MemberDAL();
		}
	}

	// @return array of Console objects
	public function getMembers() {
		return $this->getMemberDAL()->getMembers();
	}

	// @return Console
	public function getMember($memberId) {
		return $this->getMemberDAL()->getMember($memberId);
	}

	// @param int $memberId
	public function deleteMember($memberId) {
		$this->getMemberDAL()->deleteMember($memberId);
	}

	// @param Console $console
	public function saveMember(Member $member) {
		$this->getMemberDAL()->saveMember($member);
	}

	// Boat

	// @var BoatDAL $boatDAL
	private $boatDAL;

	// @return GameDAL $boatDAL
	public function getBoatDAL() {
		if(isset($this->boatDAL)) {
			return $this->boatDAL;
		}
		else {
			return new BoatDAL();
		}
	}

	// @return array of Game objects
	public function getBoats($memberId) {
		return $this->getBoatDAL()->getBoats($memberId);
	}

	// @return Game 
	public function getBoat($boatId) {
		return $this->getBoatDAL()->getBoat($boatId);
	}

	// @param Game $game
	public function saveBoat(Boat $boat) {
		$this->getBoatDAL()->saveBoat($boat);
	}

	// @param int $boatId
	// @param int $memberId
	public function deleteBoat($boatId, $memberId) {
		$this->getBoatDAL()->deleteBoat($boatId, $memberId);
	}
}