<!--start --> 
<?php 
$ref = $_SERVER['REQUEST_URI'];
$host = $_SERVER['SERVER_NAME'];
$shortcuts = true;

$ref = explode('/',$ref);
$referencia = null;
$include = null;


if (isset($ref[2])) {

  $referencia = $ref[2];
  $array = explode('?',$referencia);
  if (count($array)>1) {
  list($link,$demas)= explode('?',$referencia);
  } else {
    $link = $referencia;
  }
  $referencia = $link;

}


if (!is_null($referencia)) {
  
  switch ($referencia) {
    
    case 'inbox':
      $referencia = __('Capturing');
      $include = 'my_inbox';
      break;
    case 'organize':
      $referencia = __('Organizing');
      $include = 'project';
      break;
     case 'organize':
      $referencia = __('Organizing');
      $include = 'organizing';
      break;
     case 'doing_work':
      $referencia = __('Engaging');
      $include = 'doing';
      break;
     case 'clarify':
      $referencia = __('Clarifying');
      $include = 'process';
      break;
     case 'criteria_management':
      $referencia = __('Criteria');
      $include = 'criteria';
      break;
     case 'folder_management':
      $referencia = __('references');
      $include = 'folder';
      break;
     case 'calendar':
      $referencia = __('calendar');
      $include = 'calendar';
      break; 
     case 'wizard_project':
      $referencia = __('wizard');
      $include = 'project';

      break;
     case 'register':
      $referencia = __('register');
      $include = 'home';
      break;
     case 'someday':
      $referencia = __('some_day_items') ;
      $include = 'some_day_items';

      break;
     case 'user_management':
      $referencia = __('Alerts');
      $include = '';
      break;
     case 'my_settings':
      $referencia = __('my_settings');
      $include = 'my_settings';
      break;
      
  
  }
  
} else {

  //SOMETHING HERE

}

?>

      <?php 
      
      if ($include) {
        include_partial('global/menu_'.$include,array('shortcuts'=>$shortcuts)); 
      } else {
         
         include_partial('global/menu_home'); 
          
      
      }
      ?>
      
	
