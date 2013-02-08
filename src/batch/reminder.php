<?php
/*
* This code work on console with php-cli
* Example: :~$ php email 1
* "1" is a id from some user on EasyGtd
* @param int $argv[1] es la id que se pasa desde consola
*/
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', false);

sfContext::createInstance($configuration);

#obtener todos los usuarios
$users = Doctrine::getTable('SfGuardUser')->findAll();

foreach ($users as $user) {
  
  #reviso si tienen configuracion para las alertas
  
  $alerts = Doctrine_Query::create()->from('AlertConfiguration ac')->where('ac.user_id=?',$user->getId())->execute();
  
  if ($alerts->count() > 0 ) {
    
    AlertasCorreo::getInstance()->alertas($user->getId());
  }
  
  $alerts = null;
  
  
}

