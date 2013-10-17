<?php

namespace login\model;

class UserName {
	const MINIMUM_USERNAME_LENGTH = 3;
	const MAXIMUM_USERNAME_LENGTH = 9; 

	public function __construct($userName) {
		$this->isOkUserName($userName);

		$this->userName = $userName;
	}

	public function __toString() {
		return $this->userName;
	}

	private function isOkUserName($string) {
		if (\Common\Filter::hasTags($string) == true) {
			throw new \Exception("Användarnamnet innehåller ogiltiga tecken.");
		} else if (strlen($string) < self::MINIMUM_USERNAME_LENGTH || strlen($string) > self::MAXIMUM_USERNAME_LENGTH) {
			throw new \Exception("Användarnamnet måste bestå av mellan 3 och 9 tecken.");
		}
	}
}