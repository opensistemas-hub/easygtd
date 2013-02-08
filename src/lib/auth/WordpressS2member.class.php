<?php 

class WordpressS2Member {

  public function checkPassword($username, $password){
    //Pregunto primero en wordpress
    $util = new PasswordHash(8, TRUE);
    //Password desde wordpress
    //Me conecto a la BD de Wordpress para buscar el usuario
    $link = mysql_connect(sfConfig::get('app_sf_guard_plugin_wordpress_server'), sfConfig::get('app_sf_guard_plugin_wordpress_user'), sfConfig::get('app_sf_guard_plugin_wordpress_password'));
    if (!$link) return false;

    $db_selected = mysql_select_db(sfConfig::get('app_sf_guard_plugin_wordpress_database'), $link);
    if (!$db_selected) {
      mysql_close($link);
      return false;
    }

    $sql = "SELECT user_pass as hash FROM wp_users WHERE user_email = '".$username."'";
  
    $result = mysql_query($sql,$link);
    if (!$result) {
      mysql_close($link);
      return false;
    }

    $hash = md5(rand().rand());
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $hash = $row['hash'];
    }    
    mysql_close($link);
    return $util->CheckPassword($password, $hash);
  }

}
