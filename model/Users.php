<?php
/*
*
*/
class Users extends Model{

	private $_userId;
	private $_token;

	public function __construct($params){

	}

	private function setUserId($userId){
		$this->_userId = $userId;
	}

}