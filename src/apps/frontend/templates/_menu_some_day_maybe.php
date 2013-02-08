<?php if ($sf_user->isAuthenticated()) { ?>

<?php 
echo link_to(image_tag('icons/project.png', array('alt' => '', 'class'=>'float-left')).__('project_wizard'),'@wizard_project',array('class'=>'float-left')); 
echo link_to(image_tag('icons/calendar.png', array('alt' => '', 'class'=>'float-left')).__('calendar'),'@calendar',array('class'=>'float-left'));
echo link_to(image_tag('icons/references.png', array('alt' => '', 'class'=>'float-left')).__('references'),'folder_management/index',array('class'=>'float-left'));
?>

<?php } ?>
