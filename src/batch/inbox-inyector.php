<?php
/*
* This code work on console with php-cli
* Example: :~$ php email 1
* "1" is a id from some user on EasyGtd
* @param int $argv[1] es la id que se pasa desde consola
*/

function _encodeHeader($input) {
   mb_internal_encoding('UTF-8');
   $v = str_replace("_"," ", mb_decode_mimeheader($input));
   return $v;
}

function extract_emails_from($string){
  preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
  return $matches[0];
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);

sfContext::createInstance($configuration);

if (!extension_loaded("mailparse")) {
	dl("mailparse.so");
}

if ($argv[1])
	$filename = $argv[1];
else
	$filename = "/tmp/mymessage.txt";

/* parse the message and return a mime message resource */
$mime = mailparse_msg_parse_file($filename);

/* return an array of message parts - this consists of the names of the parts
 * only */
$struct = mailparse_msg_get_structure($mime);

/* print a choice of sections */
$to = "";
$subject = "";
echo "PASO 1 - OK".chr(10);
foreach($struct as $st)	{
 	/* get a handle on the message resource for a subsection */
	$section = mailparse_msg_get_part($mime, $st);
	/* get content-type, encoding and header information for that section */
	$info = mailparse_msg_get_part_data($section);
        if (isset($info['headers']['to'])) {
          $to = extract_emails_from($info['headers']['to']);
          $to = $to[0];
        }
        if (isset($info['headers']['subject'])) {
          $subject = $info['headers']['subject'];
        }
 }

echo "PASO 2 - OK - EMAIL A:".$to.chr(10);

if ((strlen($to) > 0) and (strlen($subject) > 0)) {
  $user = Doctrine_Query::create()->from('EmailToInbox e')->where('e.value = ?',$to)->execute()->getFirst();
  if ($user instanceof EmailToInbox) {
    //Creo un stuff:
    $stuff = new Stuff();
    $stuff->setStuffStateId(1); //TO INBOX
    $stuff->setName(_encodeHeader($subject));
    $stuff->setDescription('[email: '.$to.']');
    $stuff->setSfGuardUser($user->getSfGuardUser());
    $stuff->save();
    echo "STUFF INYECTADO:"._encodeHeader($subject)." - ".chr(10);
  } else {
    echo "EMAIL NO ENCONTRADO.".chr(10);
  }

} else {
  echo "NO SE PUDO INYECTAR:"._encodeHeader($subject)." - A: ".$to.chr(10);
}

