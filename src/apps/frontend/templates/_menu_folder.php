<?php if ($sf_user->isAuthenticated()) { ?>

<?php 
echo link_to(image_tag('icons/navigation/projects.png', array('alt' => '', 'class'=>'float-left')).__('projects'),'@project',array('class'=>'float-left', 'title' => __('projects'))); 
echo link_to(image_tag('icons/navigation/add-folder.png', array('alt' => '', 'class'=>'float-left')). __('add_new_folder'),'folder_management/new',array('class'=>'float-left modal', 'title' => __('add_new_folder')));
echo link_to(image_tag('icons/navigation/dot-green.gif', array('alt' => '', 'class'=>'float-left')).__('add_stuff'),'stuff_management/new',array('class'=>'float-left modal first', 'title' => __('add_stuff'))); 
?>

<?php } ?>
