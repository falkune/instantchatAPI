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
		if($this->isConnected()){
			$request = $this->_connexion->prepare("SELECT user_id, user_name FROM Users WHERE user_id IN (SELECT connected_user FROM Connexion WHERE connexion_end IS NULL AND token=?) ORDER BY user_login");
			$request->execute(array($this->_token));

			$result = $request->fetchAll(PDO::FETCH_ASSOC);

			return $response = json_encode([
				'status'	=>	'ok',
				'message'	=>	'API : succes',
				'date'		=>	$result
			]);
		}
		else{
			return $response = json_encode([
				'status'	=>	'failled',
				'message' =>	'you are not connected'
			]);
		}
		
	}

	private function isConnected(){
    // this function check if the user is connected or not
    $request = $this->_connexion->prepare("SELECT COUNT(*) AS him FROM Connexion WHERE connected_user=? AND token=?");
    $request->execute(array($this->_transmitter, $this->_token));

    $result = $request->fetch();

    if($result['him'] == 1)
      return true;
    else
      return false;
  }

	private function checkParams($params){
		if(count($params) == 2)
			return true;
		else
			return false;
	}

}