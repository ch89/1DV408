<?php

class LoginModel {

	//@var string $username
	//@var string $password
	//@var CookieDAL $cookieDAL

	private static $username = "admin";
	private static $password = "pass";
	private $cookieDAL;

	public function LoginModel() {
		$this->cookieDAL = new CookieDAL();
	}

	//@throw Exception if the username or the password are invalid.

	public function validUser(User $user) {
		$un = $user->getUsername();
		$pw = $user->getPassword();
		
		if($un != self::$username || $pw != self::$password) {
			throw new Exception("Ogiltigt användarnamn och/eller lösenord.");
		}
	}

	//@var string $username
	//@var string $password
	//@var date $time

	public function saveCookieData($username, $password, $time) {
		$this->cookieDAL->insertCookieData($username, $password, $time);
	}

	//@var string $username
	//@var string $password

	public function checkCookie($username, $password) {
		$this->cookieDAL->getCookieData($username, $password);
	}

	public function removeCookieData() {
		$this->cookieDAL->removeCookieData();
	}
}