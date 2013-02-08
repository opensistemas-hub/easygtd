<?php if ($sf_user->isAuthenticated()) { ?>
  <?php echo link_to(image_tag('icons/navigation/dot-green.gif', array('alt' => '', 'class'=>'float-left')).__('add_stuff'),'stuff_management/new',array('class'=>'float-left modal first', 'title' => __('add_stuff'))); ?>
<?php } else { ?>
  <?php echo link_to(image_tag('icons/navigation/register.png', array('alt' => '', 'class'=>'float-left')).__('register'),'register/index', array('class'=>'float-left', 'title' => __('register'))); ?>
  <?php echo link_to(image_tag('icons/navigation/login.png', array('alt' => '','class'=>'float-left')).__('login'),'@sf_guard_signin', array('class'=>'float-left', 'title' => __('login'))); ?>
<?php } ?>

