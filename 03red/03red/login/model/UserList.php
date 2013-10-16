<?php

namespace login\model;


require_once("UserCredentials.php");
require_once("common/model/PHPFileStorage.php");

class UserList {
	private $adminFile;

	private $users;

	public function  __construct( ) {
		$this->users = array();
		
		$this->loadAdmin();
		$this->loadUsers();
	}

	public function findUser($fromClient) {
		foreach($this->users as $user) {
			if ($user->isSame($fromClient) ) {
				\Debug::log("found User");
				return  $user;
			}
		}
		throw new \Exception("could not login, no matching user");
	}

	public function usernameIsTaken($fromClient) {
		foreach($this->users as $user) {
			if ($user->usernameExists($fromClient) ) {
				throw new \Exception("The username is already taken.");
			}
		}
	}

	public function update($changedUser) {
		$this->adminFile->writeItem($changedUser->getUserName(), $changedUser->toString());

		\Debug::log("wrote changed user to file", true, $changedUser);
		$this->users[$changedUser->getUserName()->__toString()] = $changedUser;
	}

	private function loadAdmin() {
		
		$this->adminFile = new \common\model\PHPFileStorage("data/admin.php");
		try {
			$adminUserString = $this->adminFile->readItem("Admin");
			$admin = UserCredentials::fromString($adminUserString);

		} catch (\Exception $e) {
			\Debug::log("Could not read file, creating new one", true, $e);

			$userName = new UserName("Admin");
			$password = Password::fromCleartext("Password");
			$admin = UserCredentials::create( $userName, $password);
			$this->update($admin);
		}

		$this->users[$admin->getUserName()->__toString()] = $admin;
	}

	private function loadUsers() {
		
		$this->adminFile = new \common\model\PHPFileStorage("data/admin.php");

		$userList = $this->adminFile->readAll();

		foreach($userList as $userStr) {
			$user = UserCredentials::fromString($userStr);
			$this->users[$user->getUserName()->__toString()] = $user;
		}
	}

	public function regNewUser($user) {
		$this->usernameIsTaken($user);
		$this->update($user);
	}
}