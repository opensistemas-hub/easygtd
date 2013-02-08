<?php 
  //if $accessStatus is true, the login is true
  if ($user->isAuthenticated()) {
    include_partial('successpage',array('user' => $user));
  } else {
    include_partial('homepage');
  }

?>

