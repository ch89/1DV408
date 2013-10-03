<?php

class User {

	//@var string $username
	//@var string $password

	private $username;
	private $password;

	//@param string $username
	//@param string $password

	public function User($username, $password) {
		$this->setUsername($username);
		$this->setPassword($password);
	}

	//@param string $username

	public function setUsername($username) {
		if(empty($username)) {
			throw new Exception("Ett användarnamn måste anges.");
		}
		$this->username = $username;
	}

	//@param string $username

	public function setPassword($password) {
		if(empty($password)) {
			throw new Exception("Ett lösenord måste anges.");
		}
		$this->password = $password;
	}

	//@return string $username

	public function getUsername() {
		return $this->username;
	}

	//@return string $password

	public function getPassword() {
		return $this->password;
	}
}