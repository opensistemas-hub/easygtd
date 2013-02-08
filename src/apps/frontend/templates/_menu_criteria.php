<?php if ($sf_user->isAuthenticated()) { ?>

<?php 
  if (!isset($filter)) {
    $filter = null;
  }
?>

<?php echo link_to( image_tag('icons/navigation/dot-green.gif', array('class'=>'float-left')).__('add_new_criteria'),'criteria_management/new?filter='.$filter, array('class'=>'float-left modal', 'title' => __('add_new_criteria')))?>

<?php } ?>
