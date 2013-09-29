<?php


class LoginModel {
	private static $username = "admin";
	private static $password = "pass";

	public function validUser(User $user) {
		if($user->getUsername() != self::$username || $user->getPassword() != self::$password) {
			throw new Exception("Ogiltigt användarnamn och/eller lösenord.");
		}
	}
}