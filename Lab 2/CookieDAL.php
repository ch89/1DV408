<?php

class CookieDAL {
	//@var string $tableName
	//@var mysqli $mysqli

	private static $tableName = "Cookie";
	private $mysqli;

	public function CookieDAL() {
		$this->mysqli = new mysqli("localhost", "root", "", "Cookies");
	}

	//@param string $username
	//@param string $password
	//@param date $expireDate

	public function insertCookieData($username, $password, $expireDate) {
		$sql = "INSERT INTO " . self::$tableName . "
				(Username, Password, ExpireDate) VALUES(?, ?, FROM_UNIXTIME(?));";

		$statement = $this->mysqli->prepare($sql);
		$statement->bind_param("ssi", $username, $password, $expireDate);
		$statement->execute();
	}

	//@param string $username
	//@param string $password
	//@throws Exception if the cookie value has been manipulated
	//@throws Exception if the cookie expire time has been manipulated

	public function getCookieData($username, $password) {
		$sql = "SELECT * FROM " . self::$tableName . "
				WHERE Username = ? AND Password = ?;";
				
		$statement = $this->mysqli->prepare($sql);
		$statement->bind_param("ss", $username, $password);
		$statement->execute();

		$result = $statement->get_result();
		$expireDate;

		$rows = 0;
		while($obj = $result->fetch_array(MYSQLI_ASSOC)) {
			$expireDate = $obj["ExpireDate"];
			$rows = 1;
		}

		if($rows < 1) {
			throw new Exception("Kakans värde har manipulerats.");
		}

		if($expireDate < date('Y-m-d H:i:s')) {
			throw new Exception("Kakans utgångsdatum har manipulerats.");
		}
	}

	public function removeCookieData() {
		$sql = "DELETE FROM " . self::$tableName . ";";
		$statement = $this->mysqli->prepare($sql);
		$statement->execute();
	}
}