<?php
class HomeComponents extends sfComponents {
  
  public function executeMain_menu(){
          
  }
  
  public function executeRemaining_actions() {
    $user = $this->userId;
    $this->actions = Doctrine_Query::create()->from('Stuff s')->where('s.User.id=?',$user)->addWhere('s.StuffState.id=?',1)->execute();
  
  }    
  
}
