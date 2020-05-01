<?php
/*
*THIS CLASS CONNECT USERS IN THE PATEFORM AND NEED :
*EMAIL ADDRESS AN PASSWORD FOR THIS JOB, BEFORE CONNECTING
*USER THEY VERIFIE IF THE USER IS NOT ALLREADY CONNECTED.
*PARAMS WILL BE PASSED LIKE THIS : login/password
*EXEPTED THE CONSTRUCTOR ALL METHODS OF THE CLASS ARE PRIVATE
*BECAUSE WE DONT NEED TO USE THEM OUT OF THE CLASS.
*/

class Login extends Model{

  /* they are the attribute of the class,
  each of them are private */

  private $_login;
  private $_password;
  private $_connexion;

  public function __construct($params){

    /* this is the constructor of the class,
    it is automatically called when the class
    is instantiate, from this time he does his job */
    
    if($this->checkParams($params)){

      $this->_connexion = $this->connexion();

      $this->setLogin($params[0]);
      $this->setPassword($params[1]);

      echo $this->signin();
      
    }
    else{
      echo "argument passe not match !!!";
    }

  }

  private function signin(){

    /* this function connected user in the plateform. */

    $request = $this->_connexion->prepare("SELECT COUNT(user_email), user_id FROM Users WHERE user_email=?");
    $request->execute(array($this->_login));
    $numberOfRows = $request->fetch();

    if($numberOfRows['COUNT(user_email)'] == 1){

      $id = $numberOfRows['user_id'];

      if( ! $this->isAllreadyConnected($id) ){

        $token = uniqid($id);
        $request = $this->_connexion->prepare("INSERT INTO Connexion (connexion_start, ip_address, token, connected_user) VALUES (?, ?, ?, ?)");
        $request->execute(array(time(), $_SERVER['REMOTE_ADDR'], $token, $id));

        return $response = json_encode([
          'status'  =>  'ok',
          'message' =>  'conected',
          'token'   =>  $token
        ]);

      }
      else{
        $request = $this->_connexion->prepare("SELECT token FROM Connexion WHERE connected_user=? AND token != 'expired'");
        $request->execute(array($id));
        $result = $request->fetch();

        $token = $result['token'];
        return $response = json_encode([
          'status'  =>  'active',
          'message' =>  'allready connected',
          'token'   =>  $token
        ]);

      }

    }

  }

  
  private function isAllreadyConnected($id){

    /* this function check if the user is allready connected,
    they return true in this case and false if not. */

    $request = $this->_connexion->prepare("SELECT COUNT(*) AS num FROM Connexion WHERE connected_user=? AND token != 'expired'");
    $request->execute(array($id));
    $result = $request->fetch();

    if($result['num'] == 0)
      return false;
    else
      return true;

  }

  private function isUser($login){
    /* this function check the if the email exist in database */

  }

  private function isPasswordCorrect($password){
    /* this function check if the password is correct */
    
  }


  private function setLogin($login){
    $this->_login = $login;
  }

  private function setPassword($pass){
    $this->_password = $pass;
  }

  private function setConnexion($conn){
    $this->_connexion = $conn;
  }

  private function checkParams($params){
    if(count($params) == 2)
      return true;
    else
      return false;
  }

}