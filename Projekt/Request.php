<?php

class Request {
	// @var string $consoller
	private $controller;

	// @var string $methods
	private $method;

	// @var array of strings
	private $args;

	public function Request() {
		$url = explode("/", $_SERVER["REQUEST_URI"]);
		$url = array_filter($url);

		$this->controller = ($current = array_shift($url)) ? $current : "Console";
		$this->method = ($current = array_shift($url)) ? $current : "index";
		$this->args = (count($url) > 0) ? $url : array();
	}

	// @return string
	public function getController() {
		return $this->controller;
	}

	// @return string
	public function getMethod() {
		return $this->method;
	}

	// @return string
	public function getArgs() {
		return $this->args;
	}
}