<?php echo form_tag('doing_work/add_attachment',array('enctype'=>'multipart/form-data','name'=>'add_attachment_form'))?>

<div class="hide-messages" id="message-alert-normal"><?php echo __('You sure you want to delete this action?') ?></div>
<div class="hide-messages" id="message-alert-recursive"><?php echo __('This action has other associated actions. Are you sure you want to delete?') ?></div>

<div class="show_details_from_calendar">



<h3><?php echo __('name')?></h3> <font class="font-blue"><?php echo $action->getName();?></font><br/>
<h3><?php echo __('description')?></h3> <strong><?php echo ( strlen($action->getDescription())>0)?$action->getDescription():__('no tiene descripcion') ;?></strong>
<br/>
<h3><span id="show-detail"><a href="javascript:void(0);"><?php echo __('show_details') ?></a></span></h3>
<div id="details-action" class="close-panel">

 <h4 class="float-left"><?php echo __('Context'); ?></h4><br/>
  <br/>
  <fieldset>
  <?php foreach ($contexts as $context):?>
    <li><?php echo $context;?></li>
  <?php endForeach; ?>
  </fieldset>
  <br/>
 <?php if ( count($energys)>0 ): ?> 
 <h4 class="float-left"><?php echo __('Energy'); ?></h4><br/>
  <br/>
  <fieldset>
  <?php foreach ($energys as $energy):?>
    <li><?php echo $energy;?></li>
  <?php endForeach; ?>
  </fieldset>
  
 <?php endIf; ?>
 <br/>
  <?php if ( count($prioritys)>0 ): ?> 
 <h4 class="float-left"><?php echo __('Priority'); ?></h4><br/>
  <br/>
  <fieldset>
  <?php foreach ($prioritys as $priority):?>
    <li><?php echo $priority;?></li>
  <?php endForeach; ?>
  </fieldset>
  
 <?php endIf; ?> 
<br/>
 <?php if ( count($times)>0 ): ?> 
 <h4 class="float-left"><?php echo __('Time'); ?></h4><br/>
  <br/>
  <fieldset>
  <?php foreach ($times as $time):?>
    <li><?php echo $time['value'];?> <?php echo __($time['unit']) ?></li>
  <?php endForeach; ?>
  </fieldset>
  
 <?php endIf; ?> 
  <br/>

</div>

<span id="delete-action"><a href="javascript:void(0);"><?php echo __('delete') ?></a></span>

</div>

<script type="text/javascript">
//hide messages

jq('.hide-messages').hide();

//get number of items related
var recursive_count_items = '<?php echo $recursive ?>';
jq('#details-action').hide();
jq('#attach_add').hide();
jq('#action_attachment').hide();
jq('#button_add').hide();

jq('#show-detail').bind('click',function(){

  if ( jq('#details-action').hasClass('close-panel') ) {
    jq('#details-action').show().removeClass('close-panel').addClass('open-panel');
    
  } else {
    jq('#details-action').hide().removeClass('open-panel').addClass('close-panel');
  }

});

  
jq('#show_attach').bind('click',function(){
  
  jq('#attach_add').show();
  jq('#show_attach').hide();
  jq('#action_attachment').show();
  jq('#button_add').show();
    
});

//delete method

jq('#delete-action').click(function(){
  
  if ( recursive_count_items > 1 ) {
      recursiveDelete();
    } else {
      normalDelete();
    }

});

function normalDelete() {

 jq("#message-alert-normal").dialog({
			resizable: false,
			title: '<?php echo __("delete"); ?>',
			height:180,
			modal: true,
			buttons: {
				'<?php echo __("yes")?>': function() {
          
             jq.ajax({
                 type: "delete",
                 url: "<?php echo url_for('doing_work/delete_action_from_calendar') ?>",
                 data: "id=<?php echo $action->getId(); ?>",
                 success: function(){
                    jq('#calendar_message').html('<?php echo __("the_action_was_removed_successfully") ?>').addClass('exito').show().fadeOut(999);
                    location.href="<?php echo url_for('@calendar'); ?>";

                 }, 
                 error: function(){
                    
                 }
              });
          
					jq(this).dialog('close');

				},
				'<?php echo __("no") ?>': function() {
					jq(this).dialog('close');
				}
			}
		});
		
}//end function normalDelete

function recursiveDelete() {

 jq("#message-alert-recursive").dialog({
			resizable: false,
			title: '<?php echo __("delete")?>',
			height:180,
			width: 500,
			modal: true,
			buttons: {
				'<?php echo __("Yes, only this action")?>': function() {
          jq.ajax({
                 type: "delete",
                 url: "<?php echo url_for('doing_work/delete_action_from_calendar') ?>",
                 data: "id=<?php echo $action->getId(); ?>",
                 success: function(){
                    jq('#calendar_message').html('<?php echo __("the_action_was_removed_successfully") ?>').addClass('exito').show().fadeOut(999);
                    location.href="<?php echo url_for('@calendar'); ?>";

                 }, 
                 error: function(){
                    
                 }
              });
           
          
					jq(this).dialog('close');

				},
				'<?php echo __("Yes, all action related with this")?>': function() {
          
           jq.ajax({
                 type: "delete",
                 url: "<?php echo url_for('doing_work/delete_recurrent_action') ?>",
                 data: "id=<?php echo $action->getId(); ?>",
                 success: function(){
                    jq('#calendar_message').html('<?php echo __("loading") ?>').addClass('exito').show().fadeOut(999);
                    location.href="<?php echo url_for('@calendar'); ?>";

                 }, 
                 error: function(){
                    
                 }
              }); 
          
					jq(this).dialog('close');

				},
				'<?php echo __("no") ?>': function() {
					jq(this).dialog('close');
				}
			}
		});
		
}//end function recursiveDelete

</script>


