<?php
#type: actionView
#description: If there are no shows this error criteria
?>
<?php include_partial('global/mensajes'); ?>
<?php 
$places = array('menu'=>array((array('name'=>__('process'),'url'=>null))));

?>
<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('done')))?>
<?php
if(isset($error)){
    echo $error.', press '.link_to('Here','criteria_management/new').' to add one.';
}else{
?>

<h1><?php echo __('you_do_not_have_any_action_to_process_right_now'); ?>.</h1>

<?php } ?>
</div> <!-- end navigation bar -->
