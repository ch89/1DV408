<?php

namespace controller;

class GameController extends Controller {
	// @var GameView $gameView
	private $gameView;
	
	public function GameController() {
		parent::Controller();
		$this->gameView = new \view\GameView($this->authenticationModel);
	}


	// @return string
	// @throws Exception
	// skickas inte ett giltigt konsol-id med så kan vi inte hämta 
	// några spel och då kastar vi ett undantag
	public function index($consoleId) {
		if(is_numeric($consoleId)) {
			$games = $this->service->getGames($consoleId);
			$console = $this->service->getConsole($consoleId);
			return $this->gameView->index($games, $console);
		}
		throw new Exception("Invalid argument.");
	}

	public function details($gameId, $consoleId) {
		$game = $this->service->getGame($gameId);
		$console = $this->service->getConsole($consoleId);
		return $this->gameView->details($game, $console);
	}

	// @param int $consoleId
	// @param int $gameId
	// @return string
	// Skickas ett game-id med så ska vi uppdatera ett spel,
	// annars ska vi lägga till ett nytt spel.
	public function save($consoleId, $gameId = null) {
		if($this->authenticationModel->isLoggedin()) {
			if($this->gameView->submit()) {
				$game = $this->gameView->getGame();

				if($game->hasErrors()) {
					$this->gameView->setErrorMessage($game->getErrors());
				}
				else {
					$game->setConsoleId($consoleId);
					$game->setGameId($gameId);
					$this->service->saveGame($game);

					if($this->gameView->uploadImage()) {
						$this->gameView->storeImage();
					}
					
					$this->navigator->redirectToGameIndex($consoleId);
					return;
				}
			}

			if($gameId) {
				if($game) {
					$game->setGameId($gameId);
				}
				else {
					$game = $this->service->getGame($gameId);
				}
				return $this->gameView->save($consoleId, $game);
			}
			else {
				if($game) {
					return $this->gameView->save($consoleId, $game);
				}
				else {
					return $this->gameView->save($consoleId);
				}
			}
		}
		$this->navigator->redirectToConsoleIndex();
	}

	// @param int $consoleId
	// @param int $gameId
	// Ta bort spel med det angivna id't
	public function delete($consoleId, $gameId) {
		if($this->authenticationModel->isLoggedin()) {
			$game = $this->service->getGame($gameId);

			if($game->getImage()) {
				$this->gameView->removeImage($game->getImage());
			}

			$this->service->deleteGame($gameId, $consoleId);
		}
		$this->navigator->redirectToGameIndex($consoleId);
	}
}