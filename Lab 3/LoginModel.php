<?php

class LoginModel {

	// @var string $username
	private static $username = "admin";

	// @var string $password
	private static $password = "pass";

	// @var string $user
	private static $user = "user";


	// @param User $user
	public function validUser(User $user) {
		assert($user instanceof User);
		return $user->getUsername() == self::$username && 
			   $user->getPassword() == self::$password;
	}

	// @param User $user
	public function login(User $user) {
		assert($user instanceof User);
		$_SESSION[self::$user] = $user;
	}

	// @return boolean
	public function isLoggedin() {
		return isset($_SESSION[self::$user]);
	}

	// @return User
	public function getUser() {
		return $_SESSION[self::$user];
	}

	public function logout() {
		unset($_SESSION[self::$user]);
	}
}