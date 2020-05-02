<?php
/*
*
*/
class Users extends Model{

	private $_userId;
	private $_token;
	private $_connexion;

	public function __construct($params){

	}

	private function setUserId($userId){
		$this->_userId = $userId;
	}

	private function setToken($token){
		$this->_token = $token;
	}

	private function getUsers(){
		$request = $this->_connexion->prepare("SELECT user_id, user_name FROM Users WHERE user_id IN (SELECT connected_user FROM Connexion WHERE connexion_end IS NULL AND token=? AND connected_user=?) ORDER BY user_login");
		$request->execute(array($this->_token, $this->_token));

		$result = $request->fetchAll();
		
	}

}