<?php

class Router {

	// @param Request $request
	public static function route(Request $request) {
		$controller = $request->getController();
		$method = $request->getMethod();
		$args = $request->getArgs();

		$controllerFile = $controller . "Controller.php";

		if(file_exists("controller/" . $controllerFile)) {

			$controller = file_exists($controllerFile) ? $controller : "Console";
			require_once("controller/$controllerFile");

			$controller = "controller\\" . $controller . "Controller";

			$controller = new $controller;

			$method = method_exists($controller, $method) ? $method : "index";

			try {
				if(count($args) > 0) {
					return call_user_func_array(array($controller, $method), $args);
				}
				else {
					return call_user_func(array($controller, $method));
				}
			}
			catch(Exception $e) {
			}
		}
		header("Location: /");
	}
}