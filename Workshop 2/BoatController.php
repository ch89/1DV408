<?php

class BoatController {
	private $service;
	private $boatView;

	public function BoatController() {
		$this->service = new Service();
		$this->boatView = new BoatView($this->service);
	}

	public function handleRequest() {
		if($this->boatView->createsBoat()) {
			$this->addBoat();
		}
		else if($this->boatView->updatesBoat()) {
			$this->updateBoat();
		}
		else if($this->boatView->deletesBoat()) {
			$this->deleteBoat();
		}

		return $this->boatView->getBoatsHTML();
	}

	public function addBoat() {
		$boat = $this->boatView->getBoat();
		$boat->setMemberID($_GET["memberID"]);

		if($boat->hasErrors()) {
			$this->boatView->setErrorMessage($boat->getErrors());
		}
		else {
			$this->service->addBoat($boat);
		}

		header("Location: boats.php?memberID=" . $_GET['memberID']);
	}

	public function updateBoat() {
		$boat = $this->boatView->getBoat();
		$boat->setBoatID($_GET["boatID"]);

		if($boat->hasErrors()) {
			$this->boatView->setErrorMessage($this->getErrors());
		}
		else {
			$this->service->updateBoat($boat);
		}

		header("Location: boats.php?memberID=" . $_GET["memberID"]);
	}

	public function deleteBoat() {
		$this->service->deleteBoat($_GET["boatId"], $_GET["memberID"]);
		//header("Location: boats.php?memberID=" . $_GET["memberID"]);
	}
}