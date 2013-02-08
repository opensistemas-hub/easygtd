
<?php if ( isset($found) && $found == 1 ) {
  
?>

<h5><?php echo __('The stuff you were looking for no longer exists or has been processed')?></h5>

<?php

} else {
?>
<h5><?php echo __('Your inbox is empty'); ?></h5>

<?php

} 

?>


