<?php if ($sf_user->isAuthenticated()) { ?>

<?php
  echo link_to( image_tag('icons/navigation/criterias.png', array('alt' => '', 'class'=>'float-left')).__('Criterias'),'criteria_management/index', array('class'=>'float-left', 'title' => __('Criterias')));
  echo link_to(image_tag('icons/navigation/add-project.png', array('alt' => '', 'class'=>'float-left')).__('add_new_project'),'project_management/new',array('class'=>'float-left modal', 'title' => __('add_new_project')));
  echo link_to(image_tag('icons/navigation/dot-green.gif', array('alt' => '', 'class'=>'float-left')).__('add_stuff'),'stuff_management/new',array('class'=>'float-left modal first', 'title' => __('add_stuff')));
?>

<?php } ?>
