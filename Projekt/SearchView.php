<?php

class SearchView extends GameViewBase {

	// @param array of Game objects
	// @return string
	// Listar alla spel som hittades efter sökningen av spel
	public function index(array $games = null) {
		$html = "<h2>Sök efter spel.</h2>";

		if(count($games) > 0) {
			$html .= "<table class='list'>";
			$html .= "<tr>" . $this->getTableHeader() . "<tr>";
			foreach ($games as $game) {
				$html .= "<tr>" . $this->getTableData($game) . "</tr>";
			}
			$html .= "</table>";
		}
		else {
			$html .= "No result.";
		}

		$html .= $this->getSearchForm();
		return $html;
	}

	// @return string
	private function getSearchForm() {
		return "<form action='/Search' method='post'>
					<table>
						<tr>
							<td>Titel</td>
							<td><input type='text' name='title'></td>
						</tr>
						<tr>
							<td>Utvecklare</td>
							<td><input type='text' name='developer'></td>
						</tr>
						<tr>
							<td>Lanseringsdatum</td>
							<td><input type='text' name='releaseDate'></td>
						</tr>
						<tr>
							<td>Kategori</td>
							<td><input type='text' name='category'></td>
						</tr>
						<tr>
							<td><input type='submit' name='submit' value='Sök'></td>
							<td></td>
						</tr>
					</table>
				</form>";
	}
}