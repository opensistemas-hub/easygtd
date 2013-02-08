<?php
/*
* This code work on console with php-cli
*/
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);

sfContext::createInstance($configuration);

//Me conecto a la BD de Wordpress para importar los usuarios.
$link = mysql_connect(sfConfig::get('app_sf_guard_plugin_wordpress_server'), sfConfig::get('app_sf_guard_plugin_wordpress_user'), sfConfig::get('app_sf_guard_plugin_wordpress_password'));
if (!$link) {
    die('Could not connect to wordpress: ' . mysql_error()).chr(10);
}
echo 'Connected successfully to wordpress in order to import new USERS'.chr(10);
$db_selected = mysql_select_db(sfConfig::get('app_sf_guard_plugin_wordpress_database'), $link);
if (!$db_selected) {
    mysql_close($link);
    die ('Can\'t use DB : ' . mysql_error()).chr(10);
}

  $sql = "SELECT user_email, user_registered FROM wp_users WHERE user_login NOT IN ('admin') AND user_status = 0;";
  
  $result = mysql_query($sql,$link);
  if (!$result) {
    mysql_close($link);
    die('Invalid query: ' . mysql_error()).chr(10);
  }

  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $username = $row['user_email'];
    $createdAt = $row['user_registered'];

    // Veo si el usuario está en Symfony:
    $users = Doctrine_Query::create()->from('sfGuardUser s')->where('s.username = ?',$username)->execute();
    if ($users->count() > 0) {
      //Do Nothing
    } else {
      echo 'Attempt to create username: '.$username.chr(10);
      //Creo el usuario
      $user = new sfGuardUser();
      $user->setUsername($username); 
      $user->setCreatedAt($createdAt); 
      $user->setPassword(md5(rand().rand())); 
      $user->save();
      echo 'Username :'.$username.' - CREATED'.chr(10);
    }

  }  


mysql_close($link);


