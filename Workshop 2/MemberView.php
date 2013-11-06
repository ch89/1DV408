<?php

class MemberView extends View {
	// @var string $name;
	private static $name = "view::MemberView::name";

	// @var string $socialSecurityNumber;
	private static $socialSecurityNumber = "view::MemberView::socialSecurityNumber";

	// @var string $numberOfBoats;
	private static $numberOfBoats = "view::MemberView::numberOfBoats";

	// @var string $add;
	private static $add = "view::MemberView::add";

	// @var string $errors;
	private static $errors = "view::MemberView::errors";

	// @param array $members
	// @return string HTML
	public function index(array $members) {
		$html = "<h3>Members - Compact List</h3>";

		$html .= $this->getRegButton();
		$html .= $this->getFullList();

		if(count($members) > 0) {
			$html .= "<table class='list'>";
			$html .= $this->getTableHeader();

			foreach($members as $member) {
				$html .= $this->getTableRow($member);
			}

			$html .= "</table>";
		}
		else {
			$html .= "<p>No registered members</p>";
		}

		return $html;
	}

	public function details($members, $service) {
		$html = "<h3>Members - Full List</h3>";

		$html .= $this->getRegButton();
		$html .= $this->getCompactList();

		if(count($members) > 0) {
			foreach($members as $member) {
				$html .= "<table class='full'>";
				$html .= $this->getMemberDetails($member);
				$boats = $service->getBoats($member->getMemberId());
				$num = 0;
				foreach ($boats as $boat) {
					$type = $boat->getType();
					$length = $boat->getLength();
					$num++;
					$html .= "<tr>
								<td class='header'>Boat $num - Type:</td>
								<td>$type</td>
							</tr>";
					$html .= "<tr>
								<td class='header'>Boat $num - Length:</td>
								<td>$length</td>
							</tr>";
				}
				$html .= "</table>";
			}
		}
		else {
			$html .= "<p>No registered members</p>";
		}

		return $html;
	}

	// @return string
	private function getCompactList() {
		return "<a href='/'><button>Compact List</button></a>";
	}

	// @return string
	private function getFullList() {
		return "<a href='/Member/details'><button>Full List</button></a>";
	}

	// @return string
	private function getRegButton() {
		return "<a href='/Member/save'><button>Register Member</button></a>";
	}

	// @param Member $member
	// @return string
	// Skickas en medlem med så ska vi visa vyn för uppdatering av medlem,
	// annars ska vi visa vyn för att lägga till en medlem
	public function save(Member $member = null) {
		if($member) {
			$header = "Edit Member";
			$buttonText = "Update";
		}
		else {
			$header = "Register Member";
			$buttonText = "Add";
		}
		$html = "<h3>$header</h3>";
		$html .= $this->getForm($buttonText, $member);

		if(!empty($this->message)) {
			$html .= $this->getErrorMessage($this->message);
		}
		return $html;
	}

	// @param string $buttonText
	// @param Console $member
	// @retun string HTML
	// skickas en medlem med ska formulär för uppdatering visas,
	// annars ska formulär för att lägga till medlem visas
	public function getForm($buttonText, $member) {
		if($member) {
			$memberId = $member->getMemberId();
			$name = $member->getName();
			$socialSecurityNumber = $member->getSocialSecurityNumber();
		}
		else {
			$memberId = "";
			$name = "";
			$socialSecurityNumber = "";
		}

		return "<form action='/Member/save/$memberId' method='post'>
					<table>
						<tr>
							<td>Name:</td>
							<td><input type='text' name='" . self::$name . "' value='$name'></td>
						</tr>
						<tr>
							<td>Social Security Number (ååmmdd-nnnc):</td>
							<td><input type='text' name='" . self::$socialSecurityNumber . "' value='$socialSecurityNumber'></td>
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
		return "<tr>
					<th>Name</th>
					<th>Member Number</th>
					<th>Number Of Boats</th>
					<th></th>
				</tr>";
	}

	// @return Member $member
	// hämtar ut en medlem från post när vi försöker lägga till/uppdatera en medlem
	public function getMember() {
		$member = new Member();
		$member->setName($this->filter($_POST[self::$name]));
		$member->setSocialSecurityNumber($this->filter($_POST[self::$socialSecurityNumber]));
		return $member;
	}

	// @param Member $member
	// @return string
	// Generarar html för ett medlemsobjekt. Är vi inloggade kan vi editera eller ta bort en medlem
	private function getTableRow(Member $member) {
		$memberId = $member->getMemberId();
		$name = $member->getName();
		$socialSecurityNumber = $member->getSocialSecurityNumber();
		$numberOfBoats = $member->getNumberOfBoats();

		return "<tr>
					<td><a href='/Boat/index/$memberId'>$name</a></td>
					<td>$memberId</td>
					<td>$numberOfBoats</td>
					<td>
						<a href='/Member/save/$memberId'><button>Edit</button></a>
						<a href='/Member/delete/$memberId' class='delete'><button>Delete</button></a>
				    </td>
			    </tr>";
	}

	// @return bool
	public function submit() {
		return isset($_POST[self::$add]);
	}
}