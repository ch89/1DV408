<?php

class Navigator {
	public function redirectToMemberIndex() {
		header("Location: /");
	}

	public function redirectToBoatIndex($memberId) {
		header("Location: /Boat/index/$memberId");
	}
}