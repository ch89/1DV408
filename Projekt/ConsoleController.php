<?php

require_once("ConsoleDAL.php");

class ConsoleController extends Controller {
	// @var ConsoleView $consoleView
	private $consoleView;
	
	public function ConsoleController() {
		parent::Controller();
		$this->consoleView = new ConsoleView($this->authenticationModel);
	}

	// @return string
	// Listar samtliga registrerade konsoler
	public function index() {
		$consoles = $this->service->getConsoles();
		return $this->consoleView->index($consoles);
	}

	// @return string
	// Lägger till en konsol om ett id saknas annars uppdaters en befintlig konsol
	public function save($consoleId = null) {
		if($this->authenticationModel->isLoggedin()) {
			if($this->consoleView->submit()) {
				$console = $this->consoleView->getConsole();

				if($console->hasErrors()) {
					$this->consoleView->setErrorMessage($console->getErrors());
				}
				else {
					$console->setConsoleId($consoleId);
					$this->service->saveConsole($console);
					$this->navigator->redirectToConsoleIndex();
					return;
				}
			}

			if($consoleId) {
				$console = $this->service->getConsole($consoleId);
				return $this->consoleView->save($console);
			}
			else {
				return $this->consoleView->save();
			}
		}
		$this->navigator->redirectToConsoleIndex();
	}

	// @param int $consoleId
	// Tar bort en konsol med det specifika id't
	public function delete($consoleId) {
		if($this->authenticationModel->isLoggedin()) {
			$this->service->deleteConsole($consoleId);
		}
		$this->navigator->redirectToConsoleIndex();
	}
}