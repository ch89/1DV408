<?php

class User {

	// @var string $username
	private $username;

	// @var string $password
	private $password;

	// @param string $username
	// @param string $password

	public function User($username, $password) {
		$this->setUsername($username);
		$this->setPassword($password);
	}

	// @param string $username
	public function setUsername($username) {
		if(empty($username)) {
			throw new Exception("Du måste ange ett användarnamn.");
		}
		$this->username = $username;
	}

	// @param string $password
	public function setPassword($password) {
		if(empty($password)) {
			throw new Exception("Du måste ange ett lösenord.");
		}
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