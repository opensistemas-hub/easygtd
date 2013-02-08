<?php
/*
* This code work on console with php-cli
* Example: :~$ php email 1
* "1" is a id from some user on EasyGtd
* @param int $argv[1] es la id que se pasa desde consola
*/
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);

sfContext::createInstance($configuration);

#obtengo todos los somedaymaybe que vencen hasta hoy.
$someDayMaybeCollection = Doctrine_Query::create()->from('SomedayMaybe s')->where('s.Informations.type = ?','TICKLER_DATE')->addWhere('s.Informations.value <= ?', date('Y-m-d'))->execute();
echo "SOMEDAY MAYBE TICKLER DATE ".date('Y-m-d').": ".$someDayMaybeCollection->count().chr(10);

foreach ($someDayMaybeCollection as $someDayMaybe) { 
   $stuff = new Stuff();
   $stuff->setName($someDayMaybe->getName());  
   $stuff->setDescription($someDayMaybe->getDescription());
   $stuff->setSfGuardUser($someDayMaybe->getSfGuardUser());
   $stuff->setStuffStateId(1); 
  
   //Los adjuntos:
   foreach($someDayMaybe->getNoActionableItemAttachments() as $attachment) {
     $stuffAttachment = new StuffAttachment();
     $stuffAttachment->setValue($attachment->getValue());
     $stuff->getAttachments()->add($stuffAttachment);
   }
   
   $stuff->save();
   $someDayMaybe->delete();

}

