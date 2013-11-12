<?php

namespace model;

class UserDAL extends DALBase {

	// @param string $username
	// @param string $password
	// @throws Exception
	// Hittas inte användaren i databasen så är användaruppgifterna 
	// ogiltiga och vi kastar ett undantag
	public function findUser($username, $password) {
		$sql = "SELECT * FROM User WHERE username = ? AND password = ?;";
		$stmt = $this->getMysqli()->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$stmt->bind_result($username, $password);
		
		if($stmt->fetch()) {
			return;
		}

		throw new Exception("Ogiltigt användarnamn och/eller lösenord.");
	}
}