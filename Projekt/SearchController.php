<?php

class SearchController extends Controller {
	// @var SearchView $searchView
	private $searchView;

	public function SearchController() {
		parent::Controller();
		$this->searchView = new SearchView();
	}

	// @return string
	public function index() {
		if($this->searchView->submit()) {
			try {
				$game = $this->searchView->getGame();
				$games = $this->service->searchGame($game);
			}
			catch(Exception $e) {
			}
		}
		return $this->searchView->index($games);
	}
}