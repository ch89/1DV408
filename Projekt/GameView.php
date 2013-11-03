<?php

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
	public function index(array $games, $consoleId) {
		$html = "";
		
		if($this->authenticationModel->isLoggedin()) {
			$html .= $this->getRegButton($consoleId);
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
		if($game) {
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
	public function getForm($buttonText, $consoleId, $game) {
		if($game) {
			$gameId = $game->getGameId();
			$title = $game->getTitle();
			$developer = $game->getDeveloper();
			$releaseDate = $game->getReleaseDate();
			$url = "/Game/save/$consoleId/$gameId";
		}
		else {
			$gameId = "";
			$title = "";
			$developer = "";
			$releaseDate = "";
			$url = "/Game/save/$consoleId";
		}
		
		return "<form action='$url' method='post'>
					<table>
						<tr>
							<td>Titel</td>
							<td><input type='text' name='title' value='$title'></td>
						</tr>
						<tr>
							<td>Utvecklare</td>
							<td><input type='text' name='developer' value='$developer'></td>
						</tr>
						<tr>
							<td>Lanseringsdatum</td>
							<td><input type='text' name='releaseDate' value='$releaseDate'></td>
						</tr>
						<tr>
							<td>Kategori</td>
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
	public function getTableData(Game $game) {
		$html = parent::getTableData($game);
		$consoleId = $game->getConsoleId();
		$gameId = $game->getGameId();

		if($this->authenticationModel->isLoggedin()) {
			$html .= "<td>
						<a href='/Game/save/$consoleId/$gameId'><button>Edit</button></a>
						<a href='/Game/delete/$consoleId/$gameId'><button>Delete</button></a>
					</td>";
		}
				
		return $html;
	}
}