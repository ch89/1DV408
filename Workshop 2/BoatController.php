<?php

class BoatController extends Controller {
	// @var BoatView $boatView
	private $boatView;
	
	public function BoatController() {
		parent::Controller();
		$this->boatView = new BoatView();
	}


	// @return string
	// @throws Exception
	// skickas inte ett giltigt medlems-id med så kan vi inte hämta 
	// några båtar och då kastar vi ett undantag
	public function index($memberId) {
		if(is_numeric($memberId)) {
			$boats = $this->service->getBoats($memberId);
			return $this->boatView->index($this->service, $boats, $memberId);
		}
		throw new Exception("Invalid argument.");
	}

	// @param int $memberId
	// @param int $boatId
	// @return string
	// Skickas ett båt-id med så ska vi uppdatera en båt,
	// annars ska vi lägga till en ny båt.
	public function save($memberId, $boatId = null) {
		if($this->boatView->submit()) {
			$boat = $this->boatView->getBoat();

			if($boat->hasErrors()) {
				$this->boatView->setErrorMessage($boat->getErrors());
			}
			else {
				$boat->setMemberId($memberId);
				$boat->setBoatId($boatId);
				$this->service->saveBoat($boat);
				$this->navigator->redirectToBoatIndex($memberId);
				return;
			}
		}
		if($boatId) {
			$boat = $this->service->getBoat($boatId);
			return $this->boatView->save($memberId, $boat);
		}
		else {
			return $this->boatView->save($memberId);
		}
		$this->navigator->redirectToMemberIndex();
	}

	// @param int $memberId
	// @param int $boatId
	// Ta bort båt med det angivna id't
	public function delete($memberId, $boatId) {
		$this->service->deleteBoat($boatId, $memberId);
		$this->navigator->redirectToBoatIndex($memberId);
	}
}