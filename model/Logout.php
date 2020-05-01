<?php
/*
*THIS CLASS DISCONNECT USERS FROM THE PLATEFORM,
*THE PARMETERS NEED IS THE USER_ID AND THE TOKEN.
*PARAMS WILL BE PASSED LIKE THIS : user_id/token
*EXEPTED THE CONSTRUCTOR ALL METHODS OF THE CLASS ARE PRIVATE
*BECAUSE WE DONT NEED TO USE THEM OUT OF THE CLASS.
*/
class Logout extends Model{

  /* they are the attribute of the class,
  each of them are private */

  private $_userId;
  private $_token;
  private $_connexion;

  public function __construct($params){

    /* this is the constructor of the class,
    it is automatically called when the class
    is instantiate, from this time he does his job */

    if($this->checkParams($params)){

      $this->setUserId($params[0]);
      $this->setToken($params[1]);

      $this->_connexion = $this->connexion();

      echo $this->getOut();
    }
    else{
      echo "arguments does not match !!!";
    }

  }

  private function setUserId($userId){
    $this->_userId = $userId;
  }

  private function setToken($token){
    $this->_token = $token;
  }

  private function checkParams($params){
    if(count($params) == 2)
      return true;
    else
      return false;
  }

  // this function disconnect the user from the plateform.
  private function getOut(){

    $request = $this->_connexion->prepare("SELECT COUNT(*) AS him FROM Connexion WHERE connected_user=? AND token=?");
    $request->execute(array($this->_userId, $this->_token));

    $result = $request->fetch();
    if($result['him'] == 1){
      $request = $this->_connexion->prepare("UPDATE Connexion SET connexion_end = ?, token = ? WHERE connected_user = ?");
      $request->execute(array(time(), "expired", $this->_userId));

      return $response = json_encode([
        'status'  => 'ok',
        'message' =>  'disconected'
      ]);
    }
    else{
      return $response = json_encode([
        'status'  => 'failled',
        'message' =>  'bad token or identifiant'
      ]);
    }

  }

}