


<?php 

$places = array(
                'menu'=>array(
                                
                                 array('name'=>__('main_panel'),'url' => 'homepage'),
                                array('name'=>__('alert_configuration'),'url' => null)
                              )             
              );
?>
<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('alert_configuration')))?>

<div class="content-general-with-mark" class="float-left"><h3><?php echo __('you_can_configure_to_receive_notification that_you_assign_elements_in_your_email_account'); ?>.</h3>
            	<br/>
            	
            	
  <div id="div-messages"></div>          

<div id="form-alert">

<?php include_partial('alert_form',array('form'=>$form,'datas'=>$datas)); ?>


</div>
<?php include_partial('global/navigation_bar_end'); ?>
</div>

<script type="text/javascript">

<?php if ($sf_user->hasFlash('mensajes')): ?>
  renderMessages('<?php echo __($sf_user->getFlash("mensajes")) ?>','success');
<?php endif; ?>



var mail = "<?php echo $email; ?>";

jq('#get_email').click(function(){

  jq('#email').val(mail);

});


</script>
