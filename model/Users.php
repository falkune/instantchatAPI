<?php
/*
*THIS CLASS STAND FOR LIST ALL USER OF THE PLATEFORME,
*FOR THIS THEY REQUIRE THE CONNECTED USER_ID AND THE TOKEN.
*PARAMS WILL BE PASSED LIKE THIS : user_id/token
*EXEPTED THE CONSTRUCTOR ALL METHODS OF THE CLASS ARE PRIVATE
*BECAUSE WE DONT NEED TO USE THEM OUT OF THE CLASS.
*/
class Users extends Model{

	private $_userId;
	private $_token;
	private $_connexion;

	public function __construct($params){

		 /* this is the constructor of the class,
    it is automatically called when the class
    is instantiate, from this time he does his job */

		if($this->checkParams($params)){

			// initialisation of the class attributes
			$this->setUserId($params[0]);
			$this->setToken($params[1]);


      // connexion initialisation
			$this->_connexion = $this->connexion();

			// display the liste of the users.
			echo $this->getUsers();
		}
		else{
			return $response = json_encode([
				'status'	=>	'failled',
				'message'	=>	'params does not match !'
			]);
		}
	}

	private function setUserId($userId){
		$this->_userId = $userId;
	}

	private function setToken($token){
		$this->_token = $token;
	}

	private function getUsers(){
		if($this->isConnected()){
			$request = $this->_connexion->prepare("SELECT user_id, user_name FROM Users WHERE user_id!=?");
			$request->execute(array($this->_userId));

			$result = $request->fetchAll(PDO::FETCH_ASSOC);

			return $response = json_encode([
				'status'	=>	'ok',
				'message'	=>	'API : succes',
				'data'		=>	$result
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
    $request->execute(array($this->_userId, $this->_token));

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
