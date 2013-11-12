<?php

namespace model;

class GameDAL extends DALBase {

	// @param string $sql
	// @param int $id
	// @return array of games
	public function getAllGames($sql, $id) {
		$stmt = $this->getMysqli()->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->bind_result($gameId, $title, $developer, $releaseDate, $category, $image, $consoleId);
		$games = array();

		while($stmt->fetch()) {
			$game = new \model\Game();
			$game->setGameId($gameId);
			$game->setTitle($title);
			$game->setDeveloper($developer);
			$game->setReleaseDate($releaseDate);
			$game->setCategory($category);
			$game->setImage($image);
			$game->setConsoleId($consoleId);
			$games[] = $game;
		}

		return $games;
	}

	// @param int $consoleId
	// @return array of Game objects
	public function getGames($consoleId) {
		$sql = "SELECT * FROM Game WHERE consoleId = ?;";
		return $this->getAllGames($sql, $consoleId);
	}

	// @param int $consoleId
	// @return Games
	// @throw Exception
	// Finns det inte ett spel med det angivna id't så kastas ett undantag
	public function getGame($gameId) {
		$sql = "SELECT * FROM Game WHERE gameId = ?;";
		$games = $this->getAllGames($sql, $gameId);

		if(count($games) == 1) {
			return $games[0];
		}

		throw new Exception("No result.");
	}

	// @param Game $game
	// har spelobjektet ett id så finns det redan och ska därmed uppdateras,
	// annars ska det skapas ett nytt spelobjekt
	public function saveGame(\model\Game $game) {
		$title = $game->getTitle();
		$developer = $game->getDeveloper();
		$releaseDate = $game->getReleaseDate();
		$category = $game->getCategory();
		$image = $game->getImage();

		if($game->getGameId()) {
			$gameId = $game->getGameId();
			if($image) {
				$sql = "UPDATE Game SET title = ?, developer = ?, releaseDate = ?, category = ?, image = ? WHERE gameId = ?;";
				$stmt = $this->getMysqli()->prepare($sql);
				$stmt->bind_param("sssssi", $title, $developer, $releaseDate, $category, $image, $gameId);
			}
			else {
				$sql = "UPDATE Game SET title = ?, developer = ?, releaseDate = ?, category = ? WHERE gameId = ?;";
				$stmt = $this->getMysqli()->prepare($sql);
				$stmt->bind_param("ssssi", $title, $developer, $releaseDate, $category, $gameId);
			}
		}
		else {
			$consoleId = $game->getConsoleId();
			$this->updateNumberOfGames($consoleId, 1);
			$sql = "INSERT INTO Game(title, developer, releaseDate, category, image, consoleId) VALUES(?, ?, ?, ?, ?, ?);";
			$stmt = $this->getMysqli()->prepare($sql);
			$stmt->bind_param("sssssi", $title, $developer, $releaseDate, $category, $image, $consoleId);
		}

		$stmt->execute();
	}

	// @param int $gameId
	// @param int $consoleId
	public function deleteGame($gameId, $consoleId) {
		$sql = "DELETE FROM Game WHERE GameId = ?;";
		$this->baseDelete($sql, $gameId, $consoleId);
	}

	// @param Game $game
	// Plockar ut alla spel som matchar sökkriterierna
	public function searchGame(\model\Game $game) {
		$sql = "SELECT * FROM Game WHERE (title LIKE ?) AND (developer LIKE ?) AND (releaseDate LIKE ?) AND (category LIKE ?) ORDER BY title;";
		$stmt = $this->getMysqli()->prepare($sql);
		$titleString = '%' . $game->getTitle() . '%';
		$developerString = '%' . $game->getDeveloper() . '%';
		$releaseDateString = '%' . $game->getReleaseDate() . '%';
		$categoryString = '%' . $game->getCategory() . '%';
		$stmt->bind_param("ssss", $titleString, $developerString, $releaseDateString, $categoryString);
		$stmt->execute();
		$stmt->bind_result($gameId, $title, $developer, $releaseDate, $category, $consoleId);

		$games = array();
		while($stmt->fetch()) {
			$game = new \model\Game();
			$game->setTitle($title);
			$game->setDeveloper($developer);
			$game->setReleaseDate($releaseDate);
			$game->setCategory($category);
			$games[] = $game;
		}

		return $games;
	}
}