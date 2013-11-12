<?php

namespace model;

class User {
	// @var string $username
	private $username;

	// @var string $password
	private $password;
	
	// @param string $username
	// @param string $password
	public function User($username, $password) {
		if(empty($username)) {
			throw new Exception("Username is required.");
		}
		if(empty($password)) {
			throw new Exception("Password is required.");
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