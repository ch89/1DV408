<?php

class GameController {

	public function edit($id) {

	}
	
	public function update(Game $game) {
		$this->repository->updateGame($game);
	}
}