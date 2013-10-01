<?php


class LoginModel {
	private static $username = "admin";
	private static $password = "pass";

	public function validUser(User $user) {
		$un = $user->getUsername();
		$pw = $user->getPassword();
		
		if($un != self::$username || $pw != self::$password) {
			throw new Exception("Ogiltigt användarnamn och/eller lösenord.");
		}
	}
}