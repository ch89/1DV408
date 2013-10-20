<?php

class BoatView {
	private static $add = "add";
	private static $update = "update";
	private static $delete = "delete";
	private static $errors = "errors";
	private static $boatID = "boatID";
	private static $type = "view::BoatView::type";
	private static $length = "view::BoatView::length";
	private static $memberID = "memberID";
	private static $submit = "view::MemberListView::submit";
	private $service;
	private $message;

	public function BoatView(Service $service) {
		$this->service = $service;
	}

	public function setErrorMessage($errors) {
		$_SESSION[self::$errors] = $errors;
	}

	public function getErrorMessage($errors) {
		$html = "<ul class='error'>";

		foreach($errors as $error) {
			$html .= "<li>$error</li>";
		}
		$html .= "</ul>";

		return $html;
	}

	public function getBoatsHTML() {
		$boatListHTML = $this->getReturnButton();
		
		$member = $this->service->getMember($_GET["memberID"]);
		$boatListHTML .= $this->getMemberHTML($member);

		$boats = $this->service->getBoats($_GET["memberID"]);

		if(count($boats) > 0) {
			$boatListHTML .= "<table class='list'>";
			$boatListHTML .= $this->getTableHeader();

			if(isset($_GET["edit"])) {
				foreach($boats as $boat) {
					$boatListHTML .= $this->getBoatHTMLEdit($boat);
				}	
			}
			else {
				foreach($boats as $boat) {
					$boatListHTML .= $this->getBoatHTML($boat);
				}	
			}

			$boatListHTML .= "</table>";
		}
		else {
			$boatListHTML .= "<p>No registered boats.</p>";
		}

		$boatListHTML .= $this->getForm();

		if(!empty($this->message)) {
			$boatListHTML .= "<p>$this->message</p>";
		}

		return $boatListHTML;
	}

	private function getReturnButton() {
		return "<a href='index.php'>Members Page</a>";
	}

	private function getMemberHTML(Member $member) {
		$memberID = $member->getMemberID();
		$name = $member->getName();
		$ssn = $member->getSocialSecurityNumber();
		$numberOfBoats = $member->getNumberOfBoats();

		$html = "<h3>Member</h3>";
		$html .= "<table>
					<tr>
						<td>Namn:</td>
						<td>$name</td>
					</tr>
					<tr>
						<td>Personnummer:</td>
						<td>$ssn</td>
					</tr>
					<tr>
						<td>Medlemsnummer:</td>
						<td>$memberID</td>
					</tr>
					<tr>
						<td>Antal båtar:</td>
						<td>$numberOfBoats</td>
					</tr>
				</table>";

		return $html;
	}

	private function getBoatHTML(Boat $boat) {
		$boatID = $boat->getBoatID();
		$type = $boat->getType();
		$length = $boat->getLength();
		$memberID = $boat->getMemberID();
		
		return "<tr>
					<td>$type</td>
					<td>$length</td>
					<td><a href='?edit&boatID=$boatID&memberID=$memberID'><button>Edit</button></a><a href='?delete&boatId=$boatID&memberID=$memberID'><button>Delete</button></a></td>
				</tr>";
	}

	private function getBoatHTMLEdit(Boat $boat) {
		$boatID = $boat->getBoatID();
		$type = $boat->getType();
		$length = $boat->getLength();
		$memberID = $boat->getMemberID();

		if($_GET[self::$boatID] == $boatID) {
			return "<form action='?update&boatID=$boatID&memberID=$memberID' method='post'>
						<tr>
							<td>
								<select name='" . self::$type . "'>
									<option>Segelbåt</option>
									<option>Motorseglare</option>
									<option>Motorbåt</option>
									<option>Kajak/Kanot</option>
									<option>Övrigt</option>
								</select>
							</td>
							<td><input type='text' name='" . self::$length . "' value='$length'></td>
							<td>
								<input type='submit' value='Update'>
								</form>
								<a href='boats.php?memberID=" . $_GET["memberID"] . "'><button>Cancel</button></a>
							</td>
						</tr>";
		}
		else {
			return "<tr>
						<td>$type</td>
						<td>$length</td>
						<td><a href='?edit&boatID=$boatID&memberID=$memberID'><button>Edit</button></a><a href='?delete&boatId=$boatID&memberID=$memberID'><button>Delete</button></a></td>
					</tr>";
		}
	}

	private function getTableHeader() {
		return "<tr>
                	<th>Type</th>
                	<th>Length</th>
                	<th></th>
                </tr>";
	}

	private function getForm() {
		$html = "<form action='?add&memberID=" . $_GET["memberID"] . "' method='post'>
					<table>
						<tr>
							<td>Typ:</td>
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
							<td>Längd (meter):</td>
							<td><input type='text' name='" . self::$length . "'></td>
						</tr>
						<tr>
							<td><input type='submit' name='" . self::$submit . "' value='Add'></td>
							<td></td>
						</tr>
					</table>
				</form>";

		if(isset($_SESSION[self::$errors])) {
			$html .= $this->getErrorMessage($_SESSION[self::$errors]);
			unset($_SESSION[self::$errors]);
		}

		return $html;
	}

	public function getBoat() {
		return new Boat($_POST[self::$type], $_POST[self::$length]);
	}

	public function createsBoat() {
		return isset($_GET[self::$add]);
	}

	public function updatesBoat() {
		return isset($_GET[self::$update]);
	}

	public function deletesBoat() {
		return isset($_GET[self::$delete]);
	}
}