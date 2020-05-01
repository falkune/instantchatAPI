<?php
/*
*THIS FUNCTION MAKE USER REGISTERING IN THE PLATEFORM,
*THEY NEED TO CHECK IF THE EMAIL IS NOT ALLREADY IN THE 
*DATABASE BEFORE CEATING THE ACCOUNT.
*PARAMS WILL BE PASSED LIKE THIS : userName/email/password
*EXEPTED THE CONSTRUCTOR ALL METHODS OF THE CLASS ARE PRIVATE
*BECAUSE WE DONT NEED TO USE THEM OUT OF THE CLASS.
*/
class Register extends Model{

  /* they are the attribute of the class,
  each of them are private */
  
  private $_userName;
  private $_userEmail;
  private $_userPassword;
  private $_connexion;

  public function __construct($params){

    /* this is the constructor of the class,
    it is automatically called when the class
    is instantiate, from this time he does his job */

    if($this->checkParams($params)){

      $this->setUserName($params[0]);
      $this->setUserEmail($params[1]);
      $this->setUserPassword($params[2]);

      $this->_connexion = $this->connexion();

      echo $this->saveUser();
      
    }
    else{
      echo "arguments deos not match !!!";
    }

  }

  private function setUserName($userName){
    $this->_userName = $userName;
  }

  private function setUserEmail($userEmail){
    $this->_userEmail = $userEmail;
  }

  private function setUserPassword($userPassword){
    $this->_userPassword = $userPassword;
  }
  
 
  private  function saveUser(){

    /* this function record the new user in the database */

    if( ! $this->checkEmail() ){
      $password = password_hash($this->_userPassword, PASSWORD_DEFAULT);
      $request = $this->_connexion->prepare("INSERT INTO Users (user_name, user_email, user_password) VALUES (?, ?, ?)");
      $request->execute(array($this->_userName, $this->_userEmail, $password));

      return $response = json_encode([
        'status'  => 'ok',
        'message' => 'successfuly add'
      ]);
    }
    else{
      return $response = json_encode([
        'status'  => 'failed',
        'message' => 'this email allready exist'
      ]);
    }

  }

  
  private function checkEmail(){

    /* this function check if the email addresse is allready use or not.
    this must return true if it is allready use an false if not. */

    $request = $this->_connexion->prepare("SELECT COUNT(*) AS num FROM Users WHERE user_email=?");
    $request->execute(array($this->_userEmail));
    $numberOfRows = $request->fetch();

    if($numberOfRows['num'] == 0)
      return false;
    else
      return true;

  }

  private function checkParams($params){

    /* this function verify if the parameter 
    sent by the user is match in nuber. */

    if(count($params) == 3)
      return true;
    else
      return false;
  }

}