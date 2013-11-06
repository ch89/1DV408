<?php

class BoatView extends View {

	// @var string $type
	private static $type = "view::BoatView::type";

	// @var string $length
	private static $length = "view::BoatView::length";

	// @var string $add
	private static $submit = "view::BoatView::submit";

	// @var string $errors
	private static $errors = "view::BoatView::errors";

	// @param array of Game objects
	// @param int $memberId
	// @return string
	// Listar alla spel som tillhör konsolen med det angivna id't
	public function index($service, array $boats, $memberId) {
		$html = "<h3>Boats</h3>";
		
		$html .= $this->getRegButton($memberId);
		$html .= $this->getReturnButton();

		$html .= "<table class='full'>";
		$member = $service->getMember($memberId);
		$html .= $this->getMemberDetails($member);
		$html .= "</table>";

		if(count($boats) > 0) {
			$html .= "<table class='list'>";
			$html .= $this->getTableHeader();

			foreach($boats as $game) {
				$html .= $this->getTableRow($game);
			}

			$html .= "</table>";
		}
		else {
			$html .= "<p>No registered boats</p>";
		}

		return $html;
	}

	// @return string
	private function getRegButton($memberId) {
		return "<a href='/Boat/save/$memberId'><button>Register Boat</button></a>";
	}

	// @return string
	private function getReturnButton() {
		return "<a href='/'><button>Members Page</button></a>";
	}

	// @param int $memberId
	// @para Boat $boat
	// @return string
	// finns det ett båtobjekt så ska vyn för uppdatering visas,
	// annars visar vi vyn för att lägga till ett båt.
	public function save($memberId, $boat = null) {
		if($boat) {
			$header = "Edit Boat";
			$buttonText = "Update";
		}
		else {
			$header = "Register Boat";
			$buttonText = "Add";
		}
		$html = "<h3>$header</h3>";
		$html .= $this->getForm($buttonText, $memberId, $boat);

		if(!empty($this->message)) {
			$html .= $this->getErrorMessage($this->message);
		}

		return $html;
	}

	// @param string $buttonText
	// @param int $memberId
	// @param Boat $boat
	// @return string
	// Finns det ett båtobjekt så visas formuläret för uppdatering med ifyllda båt-data,
	// annars visas ett tomt formulär
	public function getForm($buttonText, $memberId, $boat) {
		if($boat) {
			$boatId = $boat->getBoatId();
			$type = $boat->getType();
			$length = $boat->getLength();
			$url = "/Boat/save/$memberId/$boatId";
		}
		else {
			$gameId = "";
			$type = "";
			$length = "";
			$url = "/Boat/save/$memberId";
		}
		
		return "<form action='$url' method='post'>
					<table>
						<tr>
							<td>Type:</td>
							<td>
								<select name='" . self::$type . "'>
						 			<option>Segelbåt</option>
									<option>Motorseglare</option>
									<option>Motorbåt</option>
									<option>Kajak/Kanot</option>
									<option>Övrigt</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Length:</td>
							<td><input type='text' name='" . self::$length . "' value='$length'></td>
						</tr>
						<tr>
							<td>
								<input type='submit' name='" . self::$submit . "' value='$buttonText'>
								<a href='/Boat/index/$memberId'><button type='button'>Cancel</button></a>
							</td>
							<td></td>
						</tr>
					</table>
				</form>";
	}

	// @return string
	private function getTableHeader() {
		return "<tr>
					<th>Type</th>
					<th>Length</th>
					<th></th>
				</tr>";
	}

	// @param Boat $game
	// @return string
	private function getTableRow(Boat $boat) {
		$boatId = $boat->getBoatId();
		$type = $boat->getType();
		$length = $boat->getLength();
		$memberId = $boat->getMemberId();

		return "<tr>
					<td>$type</td>
					<td>$length</td>
					<td>
						<a href='/Boat/save/$memberId/$boatId'><button>Edit</button></a>
						<a href='/Boat/delete/$memberId/$boatId'><button>Delete</button></a>
					</td>
				</tr>";
	}

	public function submit() {
		return isset($_POST[self::$submit]);
	}

	public function getBoat() {
		$boat = new Boat();
		$boat->setType($this->filter($_POST[self::$type]));
		$boat->setLength($this->filter($_POST[self::$length]));
		return $boat;
	}
}