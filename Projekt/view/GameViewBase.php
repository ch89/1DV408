<?php

namespace view;

class GameViewBase extends ViewBase {
	
	// @return Game $game
	public function getGame() {
		$game = new \model\Game();
		$game->setTitle($this->filter($_POST["title"]));
		$game->setDeveloper($this->filter($_POST["developer"]));
		$game->setReleaseDate($this->filter($_POST["releaseDate"]));
		$game->setCategory($this->filter($_POST["category"]));

		if($this->uploadImage()) {
			$game->setImage($_FILES["image"]["name"], $_FILES["image"]["size"]);
		}

		return $game;
	}

	public function uploadImage() {
		return is_uploaded_file($_FILES['image']['tmp_name']);
	}

	public function storeImage() {
		if(!empty($_POST["img"])) {
			$this->removeImage($_POST["img"]);
		}
		move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $_FILES["image"]["name"]);
	}

	public function removeImage($image) {
		unlink("images/$image");
	}

	// @return string
	public function getTableHeader() {
		return "<th>Title</th>
				<th>Developer</th>
				<th>Release Date</th>
				<th>Category</th>";
	}

	// @return $string
	public function getTableData(\model\Game $game) {
		$gameId = $game->getGameId();
		$title = $game->getTitle();
		$developer = $game->getDeveloper();
		$releaseDate = $game->getReleaseDate();
		$category = $game->getCategory();
		$consoleId = $game->getConsoleId();

		return "<td><a href='/Game/details/$gameId/$consoleId'>$title</a></td>
				<td>$developer</td>
				<td>$releaseDate</td>
				<td>$category</td>";
	}

	// @return bool
	public function submit() {
		return isset($_POST["submit"]);
	}
}