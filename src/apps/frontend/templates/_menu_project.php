<?php if ($sf_user->isAuthenticated()) { ?>

<?php 
echo link_to(image_tag('icons/navigation/references.png', array('alt' => '', 'class'=>'float-left')).__('references'),'folder_management/index',array('class'=>'float-left', 'title' => __('references')));
echo link_to(image_tag('icons/navigation/someday_maybe.png', array('alt' => '', 'class'=>'float-left')).__('some_day_items'),'@somedaymaybe',array('class'=>'float-left', 'title' => __('some_day_items')));
echo link_to(image_tag('icons/navigation/add-project.png', array('alt' => '', 'class'=>'float-left')).__('add_new_project'),'project_management/new',array('class'=>'float-left modal', 'title' => __('add_new_project')));
echo link_to(image_tag('icons/navigation/dot-green.gif', array('alt' => '', 'class'=>'float-left')).__('add_stuff'),'stuff_management/new',array('class'=>'float-left modal first', 'title' => __('add_stuff'))); 
?>

<?php } ?>

