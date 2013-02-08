<?php

class EnviarCorreo{
    static private $instance=null;

    static function getInstance(){
    	if(self::$instance == null){
    		self::$instance = new EnviarCorreo();
    	}
    	return self::$instance;
    }
    private function __construct(){

    }
    
    function alertas($packing = array()) {
     $server =  sfConfig::get('app_SERVER_EMAIL');
     $security =  sfConfig::get('app_ENCRYPT_EMAIL');
     $port =  sfConfig::get('app_PORT_EMAIL');
     $username =  sfConfig::get('app_EMAIL_EMAIL');
     $password =  sfConfig::get('app_PASS_EMAIL');
     
     $action = false;
     $noaction = false;
     $content = '
    
    <p>EasyGtd Reminder.</p>
    <p>Hi <strong>'.$packing['name_user'].'</strong> you have '.count($packing['actions']).' things scheduled for the day <strong>'.$packing['scheluded_date'].'</strong>. <br/>
       
     ';
  
$algo = ValoresRepetidos::getInstance()->elementosRepetidos($packing['type_action']);
  foreach($algo as $row) {
    if($row['value'] == 'SOMEDAYITEM') {
      $noaction = true;
    }
    
    if($row['value'] == 'ACTION') {
      $action = true;
    }
    
  }
  
  if ($action) {
    $content .= '<p>Stuffs:</p>';
    $content.='<ul>';
    foreach ($packing['actions'] as $key => $level) {

      if ($packing['type_action'][$key] == 'ACTION') {
        $content.='<li>'.$level.'</li>';
      }

    }
    $content.='</ul>';

}

  if ($noaction) {
    $content.='<p>Some day items:</p>';
    $content.='<ul>';
    foreach ($packing['actions'] as $key => $level) {

      if ($packing['type_action'][$key] == 'SOMEDAYITEM') {
        $content.='<li>'.$level.'</li>';
      }

    }

    $content.='</ul>'; 
  }
  
      $transport = Swift_SmtpTransport::newInstance($server, $port,$security)
                            ->setUsername($username)
                            ->setPassword($password);
      $mailer = Swift_Mailer::newInstance($transport);
      $description_message=null;
            
      $message = Swift_Message::newInstance()
                             //Give the message a subject
                            ->setSubject('Alert from Easy Gtd')
                              //Set the From address with an associative array
                            ->setFrom(array('no-reply@easygtd.com' => 'EasyGtd Reminder.'))
                              //Set the To addresses with an associative array
                            ->setTo($packing['for_email'])

                            //Give it a body
                            ->setBody('EasyGtd Reminder.')

                            //And optionally an alternative body
                            //alex you to designate one thing for the day 12/12/12 before 14.30
                            ->addPart($content, 'text/html');


                            //$transport->send($message);
                            $mailer->send($message);
                            $mailer=null;
                            $message=null;
                            $transport=null;
                            $content = null;
      
    }
    
    function sendInvitation($user_id=-1,$data) {
    
     $server =  sfConfig::get('app_SERVER_EMAIL');
     $security =  sfConfig::get('app_ENCRYPT_EMAIL');
     $port =  sfConfig::get('app_PORT_EMAIL');
     $username =  sfConfig::get('app_EMAIL_EMAIL');
     $password =  sfConfig::get('app_PASS_EMAIL');
     $message_content = null;
     
     $user = Doctrine::getTable('sfGuardUser')->find($user_id);
     
     

     $message_content = 'Hi '.$data['email'].',<br/>';
     $message_content .= $user->getUsername().' has invited you to join easygtd.<br/>' ;
     $message_content .= 'just click <a href="'.$data['host_to_send'].'?hash='.$data['hash'].'">Here</a> to register';
     
    
    
     $transport = Swift_SmtpTransport::newInstance($server, $port,$security)
                            ->setUsername($username)
                            ->setPassword($password);
      $mailer = Swift_Mailer::newInstance($transport);
      $description_message=null;
            
      $message = Swift_Message::newInstance()
                             //Give the message a subject
                            ->setSubject('Invitation from EasyGtd')
                              //Set the From address with an associative array
                            ->setFrom(array('invitation@easygtd.com' => 'EasyGtd Invitation.'))
                              //Set the To addresses with an associative array
                            ->setTo($data['email'])

                            //Give it a body
                            ->setBody('EasyGtd Invitation.')

                            //And optionally an alternative body

                            ->addPart($message_content, 'text/html');


                            //$transport->send($message);
                            $mailer->send($message);
                            $mailer=null;
                            $message=null;
                            $transport=null;
                            $content = null;
      
     
     
    
    
    
    
    
    }
    
    
    function sendEmail($subject,$email,$owner,$description,$date_designed,$time){
        
        
       $transport = Swift_SmtpTransport::newInstance(sfConfig::get('app_SERVER_EMAIL'), sfConfig::get('app_PORT_EMAIL'),sfConfig::get('app_ENCRYPT_EMAIL'))
                            ->setUsername(sfConfig::get('app_EMAIL_EMAIL'))
                            ->setPassword(sfConfig::get('app_PASS_EMAIL'));
                      $mailer = Swift_Mailer::newInstance($transport);
                      $description_message=null;
                      
                      //if do not have description, this is empty
                      if($description!=""){
                          $description_message='<br/><br/>Description:<br/>'.$description;
                      }else{
                          $description_message='';
                      }
                      $message = Swift_Message::newInstance()
                             //Give the message a subject
                            ->setSubject($subject)
                              //Set the From address with an associative array
                            ->setFrom(array('reply@easygtd.com' => 'No Replay'))
                              //Set the To addresses with an associative array
                            ->setTo($email)

                            //Give it a body
                            ->setBody($owner.' you to designate a thing')

                            //And optionally an alternative body
                            //alex you to designate one thing for the day 12/12/12 before 14.30
                            ->addPart($owner.'  you to designate one thing for the day '.$date_designed.' before '.$time.$description_message, 'text/html');


                            //$transport->send($message);
                            $mailer->send($message);
                            $mailer=null;
                            $message=null;
                            $transport=null;
        
        
        
    }
    
}
