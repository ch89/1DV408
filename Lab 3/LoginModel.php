<?php

class LoginModel {
	private static $username = "admin";
	private static $password = "pass";
	private static $user = "user";

	public function validUser(User $user) {
		return $user->getUsername() == self::$username && $user->getPassword() == self::$password;
	}

	public function login(User $user) {
		$_SESSION[self::$user] = $user;
	}

	public function isLoggedin() {
		return isset($_SESSION[self::$user]);
	}

	public function getUser() {
		return $_SESSION[self::$user];
	}

	public function logout() {
		unset($_SESSION[self::$user]);
	}
}