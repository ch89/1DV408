<?php

class User {
	private $username;
	private $password;

	public function User($username, $password) {
		$this->setUsername($username);
		$this->setPassword($password);
	}

	public function setUsername($username) {
		if(empty($username)) {
			throw new Exception("Ett användarnamn måste anges.");
		}
		$this->username = $username;
	}

	public function setPassword($password) {
		if(empty($password)) {
			throw new Exception("Ett lösenord måste anges.");
		}
		$this->password = $password;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}
}