<?php
class StuffEmailExtractor{

  static private $instance=null;

  static function getInstance(){
    if(self::$instance == null){
      self::$instance = new StuffEmailExtractor();
    }
      return self::$instance;
    }

  private function __construct(){

  }
  /**
  *@param object $emailUserObj  -- need a email_user object 
  */
  
  public function extractionPop3(EmailUser $emailUserObj){
    
    $server=$emailUserObj->getServer();
    $type = $emailUserObj->getType();
    $username=$emailUserObj->getSfGuardUsername();
    $password=$emailUserObj->getPassword();
    $user_id=$emailUserObj->getSfGuardUser()->getId();
    $port = $emailUserObj->getPort();
    $ssl = $emailUserObj->getSecurity();
    
    $obj= new receiveMail($username,$password,'localhost',$server,'pop3',$port,(($ssl=='SSL') ? true : false));

    //Connect to the Mail Box
    $obj->connect();         //If connection fails give error message and exit

    // Get Total Number of Unread Email in mail box
    $tot=$obj->getTotalMails(); //Total Mails in Inbox Return integer value

    echo "Total Mails:: $tot<br>";

    for($i=$tot;$i>0;$i--)
    {
	    $head=$obj->getHeaders($i);  // Get Header Info Return Array Of Headers **Array Keys are (subject,to,toOth,toNameOth,from,fromName)
    	echo "Subjects :: ".$head['subject']."<br>";
	    echo "TO :: ".$head['to']."<br>";
	    echo "To Other :: ".$head['toOth']."<br>";
	    echo "ToName Other :: ".$head['toNameOth']."<br>";
	    echo "From :: ".$head['from']."<br>";
	    echo "FromName :: ".$head['fromName']."<br>";
	    echo "<br><br>";
	    echo "<br>*******************************************************************************************<BR>";
	    echo $obj->getBody($i);  // Get Body Of Mail number Return String Get Mail id in interger

      
      $stuffObj = new Stuff();
      $stuffObj->setName($head['subject'])
               ->setDescription((str_replace("\r\n"," ",strip_tags($obj->getBody($i)))))
               ->setSfGuardUser(Doctrine::getTable('SfGuardUser')->find($emailUserObj->getSfGuardUser()->getId()))
               ->setStuffState(Doctrine::getTable('StuffState')->find(1))
               ->save();

	
#	    $str=$obj->GetAttach($i,"./"); // Get attached File from Mail Return name of file in comma separated string  args. (mailid, Path to store file)
#	    $ar=explode(",",$str);
#	    foreach($ar as $key=>$value)
#		    echo ($value=="")?"":"Atteched File :: ".$value."<br>";
#	      echo "<br>------------------------------------------------------------------------------------------<BR>";
#	
	//$obj->deleteMails($i); // Delete Mail from Mail box
    }
    $obj->close_mailbox();   //Close Mail Box

    return false;
  
  }

  public function extractionImap(EmailUser $emailUserObj){
   
    $server=$emailUserObj->getServer();
    $type = $emailUserObj->getType();
    $username=$emailUserObj->getUsername();
    $password=$emailUserObj->getPassword();
    $user_id=$emailUserObj->getSfGuardUser()->getId();
    $port = $emailUserObj->getPort();
    $ssl = $emailUserObj->getSecurity();

    echo "Extracting .....".chr(10);

      $inbox = $this->createPathHost($emailUserObj);
     
      /* Recuperamos los emails */
      echo 'Searching for unread emails ... '.$server.chr(10);
      $emails = imap_search($inbox,'UNSEEN');
      
      $i=0;
      /* Si obtenemos los emails, accedemos uno a uno... */
      if($emails) {

        /* variable de salida */
        $output = '';

        /* Colocamos los nuevos emails arriba */
        rsort($emails);

        /* por cada email... */
     
        foreach($emails as $email_number) {

          /* Obtenemos la información específica para este email */
          $overview = imap_fetch_overview($inbox,$email_number,0);
          $message = imap_fetchbody($inbox,$email_number,1);
           
          /* Mostramos la información de la cabecera del email */

          try {
        
            $stuff = new Stuff();
            $overview[0]->seen;


            $stuff->setName(strip_tags($overview[0]->subject));
            $stuff->setDescription(str_replace("\r\n"," ",strip_tags($message)));
            $user = Doctrine::getTable('SfGuardUser')->find($user_id);
            
            if (!($user instanceof sfGuardUser)) throw new Exception('User doesnot exists!');
            $stuff->setSfGuardUser($user);

            $stuffState = Doctrine::getTable('StuffState')->find(1);
            
            if (!($stuffState instanceof StuffState)) throw new Exception('StuffState doesnot exists!');
            $stuff->setStuffState($stuffState); //The id 1 SUFF STATE - INBOX
        
            $stuff->save();
            $stuff=null;
         
            imap_setflag_full($inbox,'1,'.$overview[0]->msgno.'',"\\Seen");            

          } catch (Exception $e) {
            echo 'ERROR: '.$e->getMessage().char(10);
        }
        $i++;   
      }     

      /* Cerramos la connexión */
      imap_close($inbox);
    }
    echo $i.' EMAILS into inbox.'.chr(10);
    die();
  }

  private function  createPathHost(EmailUser $emailUserObj) {
      //IMAP 
      
      switch ($emailUserObj->getSecurity()) {
        case 'TLS':
          $hostname = '{'.$emailUserObj->getServer().':993/imap/ssl/novalidate-cert}INBOX/';
          break;
        case 'SSL':
          $hostname = '{'.$emailUserObj->getServer().':993/imap/ssl}INBOX';
          break;
        case 'NONE':
          $hostname = '{'.$emailUserObj->getServer().':993/imap/ssl/novalidate-cert}INBOX/';
          break;
            
      }
       
       echo 'Connecting to '.$hostname.chr(10);
      /* Intento de conexión */
      $inbox = imap_open($hostname,$emailUserObj->getUsername(),$emailUserObj->getPassword()) or die('Cannot connect: ' . imap_last_error());
      echo 'Connected to '.$hostname.chr(10);

    return $inbox;
  }   

}
