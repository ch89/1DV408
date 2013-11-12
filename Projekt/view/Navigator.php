<?php

namespace view;

class Navigator {
	public function redirectToConsoleIndex() {
		header("Location: /");
	}

	public function redirectToGameIndex($consoleId) {
		header("Location: /Game/index/$consoleId");
	}

	public function redirectToAuthenticationIndex() {
		header("Location: /Authentication");
	}
}