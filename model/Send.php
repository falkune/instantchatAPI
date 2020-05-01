<?php
/*
*THIS CLASS STEN FOR SENDING MESSAGE FROM ON USER TO ANOTHER,
*THEY NEED THE USER_IDS OF TRANSMITTER AND RECEIVER THEY ALSO
*NEED THE MESSAGE BODY (THE TEXT TO SEND). MESSAGE WILL BE 
*SEND ONLY IF THE TRANSMITTER IS CONNECTED.
*PARAMS WILL BE PASSED LIKE THIS : trnasmitter/receiver/message/token
*EXEPTED THE CONSTRUCTOR ALL METHODS OF THE CLASS ARE PRIVATE
*BECAUSE WE DONT NEED TO USE THEM OUT OF THE CLASS.
*/
class Send extends Model{

  /* they are the attribute of the class,
  each of them are private */

  private $_message;
  private $_transmitter;
  private $_receiver;
  private $_token;
  private $_connexion;

  public function __construct($params){

    /* this is the constructor of the class,
    it is automatically called when the class
    is instantiate, from this time he does his job */
    
    if($this->checkParams($params)){
      
      $this->setTranmetter($params[0]);
      $this->setReceiver($params[1]);
      $this->setMessage($params[2]);
      $this->setToken($params[3]);

      $this->_connexion = $this->connexion();

      echo $this->postMessage();

    }
    else{
      echo "argument does not match !!!";
    }
  }

  private function setMessage($message){
    $this->_message = $message;
  }

  private function setTranmetter($transmitter){
    $this->_transmitter = $transmitter;
  }

  private function setReceiver($receiver){
    $this->_receiver = $receiver;
  }

  private function setToken($token){
    $this->_token = $token;
  }

  private function checkParams($params){
    if(count($params) == 4)
      return true;
    else
      return false;
  }

  private function postMessage(){

    if( $this->isConnected() ){

      $request = $this->_connexion->prepare("INSERT INTO Posted_messages (message_body, message_edit_at, from_user_id, to_user_id) VALUES (?, ?, ?, ?)");
      $request->execute(array($this->_message, time(),$this->_transmitter, $this->_receiver));

      return $response = json_encode([
        'status'  =>  'ok',
        'message' =>  'messge sent'
      ]);
    }
    else{
      return $response = json_encode([
        'status'  => 'failled',
        'message' =>  'you must be connected'
      ]);
    }

  }

  private function isConnected(){
    
    $request = $this->_connexion->prepare("SELECT COUNT(*) AS num FROM Connexion WHERE connected_user=? AND token=?");
    $request->execute(array($this->_transmitter, $this->_token));
    $result = $request->fetch();

    if($result['num'] == 0)
      return false;
    else
      return true;
  }

}