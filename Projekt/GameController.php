<?php

class GameController extends Controller {
	// @var GameView $gameView
	private $gameView;
	
	public function GameController() {
		parent::Controller();
		$this->gameView = new GameView($this->authenticationModel);
	}


	// @return string
	// @throws Exception
	// skickas inte ett giltigt konsol-id med så kan vi inte hämta 
	// några spel och då kastar vi ett undantag
	public function index($consoleId) {
		if(is_numeric($consoleId)) {
			$games = $this->service->getGames($consoleId);
			return $this->gameView->index($games, $consoleId);
		}
		throw new Exception("Invalid argument.");
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
					$this->navigator->redirectToGameIndex($consoleId);
					return;
				}
			}
			if($gameId) {
				$game = $this->service->getGame($gameId);
				return $this->gameView->save($consoleId, $game);
			}
			else {
				return $this->gameView->save($consoleId);
			}
		}
		$this->navigator->redirectToConsoleIndex();
	}

	// @param int $consoleId
	// @param int $gameId
	// Ta bort spel med det angivna id't
	public function delete($consoleId, $gameId) {
		if($this->authenticationModel->isLoggedin()) {
			$this->service->deleteGame($gameId, $consoleId);
		}
		$this->navigator->redirectToGameIndex($consoleId);
	}
}