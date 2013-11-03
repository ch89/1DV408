<?php

class User {
	// @var string $username
	private $username;

	// @var string $password
	private $password;
	
	// @param string $username
	// @param string $password
	public function User($username, $password) {
		if(empty($username)) {
			throw new Exception("Ett användarnamn måste anges.");
		}
		if(empty($password)) {
			throw new Exception("Ett lösenord måste anges.");
		}
		$this->username = $username;
		$this->password = $password;
	}

	// @return string
	public function getUsername() {
		return $this->username;
	}

	// @return string
	public function getPassword() {
		return $this->password;
	}
}