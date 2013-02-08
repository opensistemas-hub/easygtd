<?php if ($sf_user->isAuthenticated()) { ?>

  <?php echo link_to(image_tag('icons/navigation/import.png', array('alt' => '', 'class'=>'float-left')).__('import_stuff'),'@inbox_import',array('class'=>'float-left modal', 'title' => __('import_stuff'))); ?>
  <?php echo link_to(image_tag('icons/navigation/dot-green.gif', array('alt' => '', 'class'=>'float-left')).__('add_stuff'),'stuff_management/new',array('class'=>'float-left modal first', 'title' => __('add_stuff')));?>

<?php } ?>
