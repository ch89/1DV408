<?php

namespace view;

class ViewBase {
	// @var string $message
	public $message;

	// @param array of strings
	// Innehåller valideringsfel
	public function setErrorMessage($errors) {
		$this->message = $errors;
	}

	// @param sting $errors
	// @return string
	public function getErrorMessage($errors) {
		$html = "";
		foreach ($errors as $error) {
			$html .= "<li>$error</li>";
		}
		return "<ul class='error'>$html</ul>";
	}

	// @param string
	// Plockar bort vissa tecken för säkerhetsskäl
	public function filter($string) {
		$string = trim($string);
		$string = stripslashes($string);
		$string = htmlentities($string);
		return $string;
	}
}