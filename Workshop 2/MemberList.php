<?php

class MemberList {
	private $members;

	public function MemberList() {
		$this->members = array();
	}

	public function add(Member $member) {
		$this->members[$member->getMemberID] = $member; 
	}

	public function getMember($id) {
		if(isset($this->members[$id])) {
			return $this->members[$id];
		}
		throw new Exception("Invalid ID");
	}

	public function getMembers() {
		return $this->members;
	}
}