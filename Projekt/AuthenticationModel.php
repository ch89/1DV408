<?php

class AuthenticationModel {
	// @var string $username
	private static $username = "model::AuthenticationModel::username";
	
	// @param string $username
	public function login($username) {
		$_SESSION[self::$username] = $username;
	}

	// @return bool
	public function isLoggedin() {
		return isset($_SESSION[self::$username]);
	}

	// @return string 
	public function getUsername() {
		return $_SESSION[self::$username];
	}

	public function logout() {
		unset($_SESSION[self::$username]);
	}
}