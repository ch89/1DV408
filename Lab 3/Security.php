<?php

class Security {

	// @var string $IPAddress
	private static $IPAddress = "model::Security::IPAddress";

	// @var string $remoteAddr
	private static $remoteAddr = "model::Security::remoteAddr";

	public static function runSecurityTest() {
		if(!isset($_SESSION[self::$IPAddress])) {
			$_SESSION[self::$IPAddress] = $_SERVER['REMOTE_ADDR'];
		}
		if(!isset($_SESSION[self::$remoteAddr])) {
			$_SESSION[self::$remoteAddr] = $_SERVER['HTTP_USER_AGENT'];
		}

		if($_SESSION[self::$IPAddress] != $_SERVER['REMOTE_ADDR'] ||
		   $_SESSION[self::$remoteAddr] != $_SERVER['HTTP_USER_AGENT']) {
		   	session_unset();
			session_destroy();
		}
	}
}