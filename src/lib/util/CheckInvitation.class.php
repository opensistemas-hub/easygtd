<?php

class CheckInvitation{
    static private $instance=null;

    static function getInstance(){
    	if(self::$instance == null){
    		self::$instance = new CheckInvitation();
    	}
    	return self::$instance;
    }
    private function __construct(){

    }
    
    function checkHash($hash=0,$active=false) {
    
      // if active is false then non check invitation
      
      if ($active) {
      
      
      //check invitation
      
      $check = Doctrine_Query::create()->from('InviteAFriend i')->Where('i.hash=?',$hash)->addWhere('i.status = ?',0)->execute()->getFirst();
      
      if ( $check instanceof InviteAFriend) {
      
        return true;

      } else {
      
          return false;
      
      
      }
      
      
        
      
      } else {
      
        //NORMAL ENTER
        
        return true;
      
      }
    
    } 
    
}
