<?php

require_once("MemberDAL.php");

class MemberController extends Controller {
	// @var MemberView $memberView
	private $memberView;
	
	public function MemberController() {
		parent::Controller();
		$this->memberView = new MemberView();
	}

	// @return string
	// Listar samtliga registrerade medlemmar
	public function index() {
		$members = $this->service->getMembers();
		return $this->memberView->index($members);
	}

	public function details() {
		$members = $this->service->getMembers();
		return $this->memberView->details($members, $this->service);
	}

	// @return string
	// Lägger till en medlem om ett id saknas annars uppdaters en befintlig medlem
	public function save($memberId = null) {
		if($this->memberView->submit()) {
			$member = $this->memberView->getMember();

			if($member->hasErrors()) {
				$this->memberView->setErrorMessage($member->getErrors());
			}
			else {
				$member->setMemberId($memberId);
				$this->service->saveMember($member);
				$this->navigator->redirectToMemberIndex();
				return;
			}
		}

		if($memberId) {
			$member = $this->service->getMember($memberId);
			return $this->memberView->save($member);
		}
		else {
			return $this->memberView->save();
		}
		$this->navigator->redirectToMemberIndex();
	}

	// @param int $memberId
	// Tar bort en medlem med det specifika id't
	public function delete($memberId) {
		$this->service->deleteMember($memberId);
		$this->navigator->redirectToMemberIndex();
	}
}