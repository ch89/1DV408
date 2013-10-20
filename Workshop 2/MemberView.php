<?php

class MemberView {
	private static $add = "add";
	private static $update = "update";
	private static $delete = "delete";
	private static $errors = "view::MemberView::errors";
	private static $action = "action";
	private static $memberID = "id";
	private static $name = "view::MemberView::name";
	private static $socialSecurityNumber = "view::MemberView::socialSecurityNumber";
	private static $numberOfBoats = "view::MemberView::numberOfBoats";
	private static $submit = "view::MemberView::submit";
	private $service;
	private $message;

	public function MemberView(Service $service) {
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

	public function getMembersHTML() {
		$members = $this->service->getMembers();

		if(count($members) > 0) {
			$memberListHTML = "<table class='list'>";
			$memberListHTML .= $this->getTableHeader();

			if(isset($_GET["edit"]) && isset($_GET["id"])) {
				foreach($members as $member) {
					$memberListHTML .= $this->getMemberHTMLEdit($member);
				}
			}
			else {
				foreach($members as $member) {
					$memberListHTML .= $this->getMemberHTML($member);
				}
			}
			
			$memberListHTML .= "</table>";
		}
		else {
			$memberListHTML = "<p>No registered members.</p>";
		}
		
		$memberListHTML .= $this->getForm();

		return $memberListHTML;
	}

	private function getMemberHTMLEdit($member) {
		$memberID = $member->getMemberID();
		$name = $member->getName();
		$socialSecurityNumber = $member->getSocialSecurityNumber();
		$numberOfBoats = $member->getNumberOfBoats();
		
		if($_GET["id"] == $memberID) {

			return "<form action='?update&id=$memberID' method='post'>
						<tr>
							<td>$memberID</td>
							<td><input type='text' name='" . self::$name . "' value='$name'></td>
							<td><input type='text' name='" . self::$socialSecurityNumber . "' value='$socialSecurityNumber'></td>
							<td>
								<input type='submit' value='Update'>
								</form>
								<a href='index.php'><button>Cancel</button></a>
							</td>
						</tr>";
		}
		else {
			return "<tr>
						<td>$memberID</td>
						<td><a href='boats.php?memberID=$memberID'>$name</a></td>
						<td>$socialSecurityNumber</td>
						<td>
							<a href='?edit&id=$memberID'><button>Edit</button></a>
							<a href='?delete&id=$memberID'><button>Delete</button></a>
						</td>
					</tr>";
		}
	}

	private function getMemberHTML(Member $member) {
		$memberID = $member->getMemberID();
		$name = $member->getName();
		$numberOfBoats = $member->getNumberOfBoats();
		
		return "<tr>
					<td><a href='boats.php?memberID=$memberID'>$name</a></td>
					<td>$memberID</td>
					<td>$numberOfBoats</td>
					<td>
						<a href='?edit&id=$memberID'><button>Edit</button></a>
						<a href='?delete&id=$memberID'><button>Delete</button></a>
					</td>
				</tr>";
	}

	private function getTableHeader() {
		return "<tr>
                	<th>Namn</th>
                	<th>Medlemsnummer</th>
                	<th>Antal båtar</th>
                	<th></th>
                </tr>";
	}

	private function getForm() {
		$html = "<h3>Registrera ny medlem</h3>";
		$html .= "<form action='?add' method='post'>
					<table>
						<tr>
							<td>Namn:</td>
							<td><input type='text' name='" . self::$name . "'></td>
						</tr>
						<tr>
							<td>Personnummer (ÅÅMMDD-NNNC):</td>
							<td><input type='text' name='" . self::$socialSecurityNumber . "'></td>
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

	public function addMember() {
		return isset($_POST[self::$submit]);
	}

	public function getMember() {
		return new Member($_POST[self::$name], $_POST[self::$socialSecurityNumber]);
	}

	public function hasMemberID() {
		return isset($_GET[self::$memberID]);
	}

	public function getMemberID() {
		return $_GET[self::$memberID];
	}

	public function createsMember() {
		return isset($_GET[self::$add]);
	}

	public function updatesMember() {
		return isset($_GET[self::$update]);
	}

	public function deletesMember() {
		return isset($_GET[self::$delete]);
	}
}