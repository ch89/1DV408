<?php

namespace view;

class ConsoleView extends ViewBase {
	// @var string $name;
	private static $name = "view::ConsoleView::name";

	// @var string $developer;
	private static $developer = "view::ConsoleView::developer";

	// @var string $releaseDate;
	private static $releaseDate = "view::ConsoleView::releaseDate";

	// @var string $add;
	private static $add = "view::ConsoleView::add";

	// @var string $errors;
	private static $errors = "view::ConsoleView::errors";

	// @var AuthenticationModel $authenticationModel;
	private $authenticationModel;

	public function ConsoleView($authenticationModel) {
		$this->authenticationModel = $authenticationModel;
	}

	// @param array $consoles
	// @return string HTML
	public function index(array $consoles) {
		$html = "";

		if($this->authenticationModel->isLoggedin()) {
			$html .= $this->getRegButton();
		}

		if(count($consoles) > 0) {
			$html .= "<table class='list'>";
			$html .= $this->getTableHeader();

			foreach($consoles as $console) {
				$html .= $this->getTableRow($console);
			}

			$html .= "</table>";
		}
		else {
			$html .= "<p>No registered consoles</p>";
		}

		return $html;
	}

	// @return string
	private function getRegButton() {
		return "<a href='Console/save'><button>Register Console</button></a>";
	}

	// @param Console $console
	// @return string
	// Skickas en konsol med så ska vi visa vyn för uppdatering av konsol,
	// annars ska vi visa vyn för att lägga till en konsol
	public function save(\model\Console $console = null) {
		if($console && $console->getConsoleId()) {
			$header = "Edit Console";
			$buttonText = "Update";
		}
		else {
			$header = "Register Console";
			$buttonText = "Add";
		}
		$html = "<h3>$header</h3>";
		$html .= $this->getForm($buttonText, $console);

		if(!empty($this->message)) {
			$html .= $this->getErrorMessage($this->message);
		}
		return $html;
	}

	// @param string $buttonText
	// @param Console $console
	// @retun string HTML
	// skickas en konsol med ska formulär för uppdatering visas,
	// annars ska formulär för att lägga till konsol visas
	public function getForm($buttonText, \model\Console $console) {
		if($console) {
			$consoleId = $console->getConsoleId();
			$name = $console->getName();
			$developer = $console->getDeveloper();
			$releaseDate = $console->getReleaseDate();
		}
		else {
			$consoleId = "";
			$name = "";
			$developer = "";
			$releaseDate = "";
		}

		return "<form action='/Console/save/$consoleId' method='post'>
					<table>
						<tr>
							<td>Name:</td>
							<td><input type='text' name='" . self::$name . "' value='$name'></td>
						</tr>
						<tr>
							<td>Developer:</td>
							<td><input type='text' name='" . self::$developer . "' value='$developer'></td>
						</tr>
						<tr>
							<td>Release Date (yyyy-mm-dd):</td>
							<td><input type='text' name='" . self::$releaseDate . "' value='$releaseDate'></td>
						</tr>
						<tr>
							<td>
								<input type='submit' name='" . self::$add . "' value='$buttonText'>
								<a href='/'><button type='button'>Cancel</button></a>
							</td>
							<td></td>
						</tr>
					</table>
				</form>";
	}

	// @return string
	private function getTableHeader() {
		$html = "<th>Name</th>
				<th>Developer</th>
				<th>Release Date</th>
				<th>Registered Games</th>";

		if($this->authenticationModel->isLoggedin()) {
			$html .= "<th></th>";
		}

		return $html;
	}

	// @return Console $console
	// hämtar ut en konsol från post när vi försöker lägga till/uppdatera en konsol
	public function getConsole() {
		$console = new \model\Console();
		$console->setName($this->filter($_POST[self::$name]));
		$console->setDeveloper($this->filter($_POST[self::$developer]));
		$console->setReleaseDate($this->filter($_POST[self::$releaseDate]));
		return $console;
	}

	// @param Console $console
	// @return string
	// Generarar html för ett konsolobjekt. Är vi inloggade kan vi editera eller ta bort en konsol
	private function getTableRow(\model\Console $console) {
		$consoleId = $console->getConsoleId();
		$name = $console->getName();
		$developer = $console->getDeveloper();
		$releaseDate = $console->getReleaseDate();
		$numberOfGames = $console->getNumberOfGames();

		$html = "<td><a href='/Game/index/$consoleId'>$name</a></td>
				<td>$developer</td>
				<td>$releaseDate</td>
				<td>$numberOfGames</td>";
					
		if($this->authenticationModel->isLoggedin()) {
			$html .= "<td>
						<a href='/Console/save/$consoleId'><button>Edit</button></a>
						<a href='/Console/delete/$consoleId' class='delete'><button>Delete</button></a>
				    </td>";
		}
					
		return "<tr>$html</tr>";
	}

	// @return bool
	public function submit() {
		return isset($_POST[self::$add]);
	}
}