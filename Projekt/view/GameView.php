<?php

namespace view;

class GameView extends GameViewBase {

	// @var string $errors
	private static $errors = "view::GameView::errors";

	// @var AuthenticationModel $authenticationModel
	private $authenticationModel;

	public function GameView($authenticationModel) {
		$this->authenticationModel = $authenticationModel;
	}

	// @param array of Game objects
	// @param int $consoleId
	// @return string
	// Listar alla spel som tillhör konsolen med det angivna id't
	public function index(array $games, \model\Console $console) {
		$html = "<h3>" . $console->getName() . "</h3>";
		
		if($this->authenticationModel->isLoggedin()) {
			$html .= $this->getRegButton($console->getConsoleId());
		}
		
		if(count($games) > 0) {
			$html .= "<table class='list'>";
			$html .= "<tr>" . $this->getTableHeader() . "</tr>";

			foreach($games as $game) {
				$html .= "<tr>" . $this->getTableData($game) . "</tr>";
			}

			$html .= "</table>";
		}
		else {
			$html .= "<p>No registered games</p>";
		}

		return $html;
	}

	public function details(\model\Game $game, \model\Console $console) {
		$html = "<table>
					<tr>
						<td>Title:</td>
						<td>" . $game->getTitle() . "</td>
					</tr>
					<tr>
						<td>Developer:</td>
						<td>" . $game->getDeveloper() . "</td>
					</tr>
					<tr>
						<td>Release Date:</td>
						<td>" . $game->getReleaseDate() . "</td>
					</tr>
					<tr>
						<td>Category:</td>
						<td>" . $game->getCategory() . "</td>
					</tr>
					<tr>
						<td>Console:</td>
						<td><a href='/Game/index/" . $game->getConsoleId() . "'>" . $console->getName() . "</a></td>
					</tr>
				</table>";

		if($game->getImage()) {
			$image = $game->getImage();
			$html .= "<img src='/images/$image' alt='Game Image'>";
		}

		return "$html";
	}

	// @return string
	private function getRegButton($consoleId) {
		return "<a href='/Game/save/$consoleId'><button>Register Game</button></a>";
	}

	// @param int $consoelId
	// @para Game $game
	// @return string
	// finns det ett spelobjekt så ska vyn för uppdatering visas,
	// annars visar vi vyn för att lägga till ett spel
	public function save($consoleId, $game = null) {
		if($game && $game->getGameId()) {
			$header = "Edit Game";
			$buttonText = "Update";
		}
		else {
			$header = "Register Game";
			$buttonText = "Add";
		}
		$html = "<h3>$header</h3>";
		$html .= $this->getForm($buttonText, $consoleId, $game);

		if(!empty($this->message)) {
			$html .= $this->getErrorMessage($this->message);
		}

		return $html;
	}

	// @param string $buttonText
	// @param int $consoleId
	// @param Game $game
	// @return string
	// Finns det ett spelobjekt så visas formuläret för uppdatering med ifyllda spel-data,
	// annars visas ett tomt formulär
	public function getForm($buttonText, $consoleId, \model\Game $game) {
		if($game) {
			$gameId = $game->getGameId();
			$title = $game->getTitle();
			$developer = $game->getDeveloper();
			$releaseDate = $game->getReleaseDate();
			$image = $game->getImage();
			$url = "/Game/save/$consoleId/$gameId";
		}
		else {
			$gameId = "";
			$title = "";
			$developer = "";
			$releaseDate = "";
			$image = "";
			$url = "/Game/save/$consoleId";
		}
		
		return "<form action='$url' method='post' enctype='multipart/form-data'>
					<table>
						<tr>
							<td>Title:</td>
							<td><input type='text' name='title' value='$title'></td>
						</tr>
						<tr>
							<td>Developer:</td>
							<td><input type='text' name='developer' value='$developer'></td>
						</tr>
						<tr>
							<td>Release Date (yyyy-mm-dd):</td>
							<td><input type='text' name='releaseDate' value='$releaseDate'></td>
						</tr>
						<tr>
							<td>Category</td>
							<td>
								<select name='category'>
						 			<option>RPG</option>
									<option>Racing</option>
									<option>Sports</option>
									<option>Platformer</option>
									<option>Puzzle</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Image</td>
							<td>
								<span>$image</span>
								<input type='file' name='image'>
								<input type='hidden' name='img' value='$image'>
							</td>
						</tr>
						<tr>
							<td>
								<input type='submit' name='submit' value='$buttonText'>
								<a href='/Game/index/$consoleId'><button type='button'>Cancel</button></a>
							</td>
							<td></td>
						</tr>
					</table>
				</form>";
	}

	// @return string
	// Hämtar tabellrubruiker från basklass
	public function getTableHeader() {
		$html = parent::getTableHeader();

		if($this->authenticationModel->isLoggedin()) {
			$html .= "<th></th>";
		}

		return $html;
	}

	// @param Game $game
	// @return string
	// hämtar tabelldata från basklass med spelobjektet som skickas med
	// Är vi inloggade kan vi uppdatera och ta bort spel
	public function getTableData(\model\Game $game) {
		$html = parent::getTableData($game);
		$consoleId = $game->getConsoleId();
		$gameId = $game->getGameId();

		if($this->authenticationModel->isLoggedin()) {
			$html .= "<td>
						<a href='/Game/save/$consoleId/$gameId'><button>Edit</button></a>
						<a href='/Game/delete/$consoleId/$gameId' class='delete'><button>Delete</button></a>
					</td>";
		}
				
		return $html;
	}
}