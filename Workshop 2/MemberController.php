<?php

class MemberController {
	private $memberView;
	private $service;
	private $memberList;

	public function MemberController() {
		$this->memberList = new MemberList();
		$this->service = new Service();
		$this->memberView = new MemberView($this->service);
	}

	public function handleRequest() {
		if($this->memberView->createsMember()) {
			$this->addMember();
		}
		else if($this->memberView->updatesMember()) {
			$this->updateMember();
		}
		else if($this->memberView->deletesMember()) {
			$this->deleteMember();
		}
		else {
			return $this->memberView->getMembersHTML();	
		}
	}

	private function addMember() {
		$member = $this->memberView->getMember();
		
		if($member->hasErrors()) {
			$this->memberView->setErrorMessage($member->getErrors());
		}
		else {
			$this->service->addMember($member);
		}

		header("Location: index.php");
	}

	private function updateMember() {
		$member = $this->memberView->getMember();

		if($member->hasErrors()) {

			$this->memberView->setErrorMessage($member->getErrors());
		}
		else {
			$member->setMemberID($_GET["id"]);
			$this->service->updateMember($member);
		}

		header("Location: index.php");
	}

	private function deleteMember() {
		$id = $this->memberView->getMemberID();
		$this->service->deleteMember($id);

		header("Location: index.php");
	}
}