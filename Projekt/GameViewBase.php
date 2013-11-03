<?php

class GameViewBase extends ViewBase {
	
	// @return Game $game
	public function getGame() {
		$game = new Game();
		$game->setTitle($this->filter($_POST["title"]));
		$game->setDeveloper($this->filter($_POST["developer"]));
		$game->setReleaseDate($this->filter($_POST["releaseDate"]));
		$game->setCategory($this->filter($_POST["category"]));
		return $game;
	}

	// @return string
	public function getTableHeader() {
		return "<th>Titel</th>
				<th>Utvecklare</th>
				<th>Lanseringsdatum</th>
				<th>Kategori</th>";
	}

	// @return $string
	public function getTableData(Game $game) {
		$title = $game->getTitle();
		$developer = $game->getDeveloper();
		$releaseDate = $game->getReleaseDate();
		$category = $game->getCategory();

		return "<td>$title</td>
				<td>$developer</td>
				<td>$releaseDate</td>
				<td>$category</td>";
	}

	// @return bool
	public function submit() {
		return isset($_POST["submit"]);
	}
}