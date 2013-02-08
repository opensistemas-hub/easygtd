<?php if ($sf_user->isAuthenticated()) { ?>

<?php
echo link_to(image_tag('icons/navigation/dot-green.gif', array('alt' => '', 'class'=>'float-left')).__('add_some_day_maybe'),'no_actionable_item_management/new_someday_maybe',array('class'=>'float-left modal first', 'title' => __('add_some_day_maybe')));
echo link_to(image_tag('icons/navigation/projects.png', array('alt' => '', 'class'=>'float-left')).__('projects'),'@project',array('class'=>'float-left', 'title' => __('projects'))); 
echo link_to(image_tag('icons/navigation/references.png', array('alt' => '', 'class'=>'float-left')).__('references'),'folder_management/index',array('class'=>'float-left', 'title' =>__('references')));
echo link_to(image_tag('icons/navigation/dot-green.gif', array('alt' => '', 'class'=>'float-left')).__('add_stuff'),'stuff_management/new',array('class'=>'float-left modal first', 'title' => __('add_stuff')));
?>

<?php } ?>
