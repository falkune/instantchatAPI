<?php
/*
*THIS CLASS STAND FO LIST ALL MESSAGE BETWEEN TWO USER,
*FOR THIS THEY NEED THE THE TWO USERS IDENTIFIANTS.
*THEY REQUIRE THE TRANSMITTER CONNECTED.
*PARAMS WILL BE PASSED LIKE THIS : trnasmitter/receiver/token
*EXEPTED THE CONSTRUCTOR ALL METHODS OF THE CLASS ARE PRIVATE
*BECAUSE WE DONT NEED TO USE THEM OUT OF THE CLASS.
*/

class Show extends Model{

  /* they are the attribute of the class,
  each of them are private */

  private $_transmitter;
  private $_receiver;
  private $_token;
  private $_connexion;

  public function __construct($params){

    /* this is the constructor of the class,
    it is automatically called when the class
    is instantiate, from this time he does his job */

    if($this->checkParams($params)){

      // initialisation of the class attributes
      $this->setTransmitter($params[0]);
      $this->setReceiver($params[1]);
      $this->setToken($params[2]);

      // connexion initialisation
      $this->_connexion = $this->connexion();

      // display discussion queue
      echo $this->showDiscution();

    }

  }

  private function setTransmitter($transmitter){
    $this->_transmitter = $transmitter;
  }

  private function setReceiver($receiver){
    $this->_receiver = $receiver;
  }

  private function setToken($token){
    $this->_token = $token;
  }

  private function checkParams($params){
    // this function check if the number of parameter is exact
    if(count($params) == 3)
      return true;
    else
      return false;
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

  private function showDiscution(){
    // this function list all message bettwen the two interlocutors
    if( $this->isConnected() ){
      $request = $this->_connexion->prepare("SELECT * FROM Posted_messages WHERE (from_user_id=? AND to_user_id=?) OR (from_user_id=? AND to_user_id=?)");
      $request->execute(array($this->_transmitter, $this->_receiver, $this->_receiver, $this->_transmitter));

      $result = $request->fetchAll(PDO::FETCH_ASSOC);
      
      return $response = json_encode([
        'status'  =>  'ok',
        'message' =>  'API : success',
        'data'    =>  $result
      ]);
    }
    else{
      return $response = json_encode([
        'status'  =>  'failled',
        'message' =>  'user not connected'
      ]);
    }
  }

}
