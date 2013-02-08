<div class="dialog-msg" id="dialog-confirm-to-inbox" >
	<?php echo __('are_you_sure_you_want_to_enter_this_item_to_the_ inbox?')?>
</div>
<div class="dialog-msg" id="dialog-confirm-delete">
	<?php echo __('Are you sure you want to delete this item for one day?') ?>
</div>

<?php
#RENDER CONTENT 
try { ?>
<table class="list"> 
  <?php if ($somedayPager->count() == 0) throw new Exception(''); ?>
  <tbody>
    <?php foreach ($somedayPager->getResults() as $someDayMaybe): ?>
    <tr id="someday_maybe_<?php echo $someDayMaybe->getId() ?>" >
      <td>
        <div class="info_wrapper"> 
        <div class="info"> 
        <div class="info_list"> 
          <?php echo $someDayMaybe->getName(); ?><br/>
          <?php foreach ($someDayMaybe->getInformations() as $information) {
                  if (($information->getType() == 'TICKLER_DATE' ) and (strlen($information->getValue()) > 0)) {
                    echo __('reprocess_at').':&nbsp;'.format_date($information->getValue(),$sf_user->getGuardUser()->getFormatDate());
                  }
                } ?>
          <ul><?php include_partial('global/SHOW_DETAILS', array('someDayMaybe'=> $someDayMaybe))?></ul>
        </div>     
        <div class="info_options">
          <a class="send_to_inbox_<?php echo $someDayMaybe->getId(); ?>" id="send_to_inbox_<?php echo $someDayMaybe->getId(); ?>" href="javascript:void(0);" title="<?php echo __('send_to_inbox'); ?>"><?php echo image_tag('icons/inbox.png',array('class'=>'', 'alt' => ''));?></a>
          <a class="delete_<?php echo $someDayMaybe->getId(); ?>" id="delete_img_<?php echo $someDayMaybe->getId(); ?>" href="javascript:void(0);" title="<?php echo __('delete'); ?>"><?php echo image_tag('icons/dot-red.gif',array('class'=>'', 'alt' => ''));?></a>
        </div>
        <div class="clear"></div>
        </div>
        </div>
      </td>      
    </tr>   
  <?php endforeach; ?>
  </tbody>
</table>

  <div style="clear:left; text-align:center;">
    <?php  echo pager_navigation($somedayPager, url_for('no_actionable_item_management/some_day_maybe'),'someday-content','ajax=false') ?>
  </div>
 


<script type="text/javascript">    
jq(function(){

  jq('#dialog-confirm-to-inbox').hide();
  jq('#dialog-confirm-delete').hide();

  <?php foreach ($somedayPager->getResults() as $someDayMaybe) { ?>
	  
	  jq('.send_to_inbox_<?php echo $someDayMaybe->getId()?>').click(function(){	  

	    jq("#dialog-confirm-to-inbox").dialog({
			resizable: false,
			title: '<?php echo $someDayMaybe->getName() ?> : <?php echo __("Send to inbox")?>',
			height:180,
			modal: true,
			buttons: {
				'<?php echo __("yes"); ?>': function() {
				   jq.ajax({
                                           type: "POST",
                                           url: "<?php echo url_for('no_actionable_item_management/return_inbox') ?>",
                                           data: "action_id=<?php echo $someDayMaybe->getId(); ?>",
                                           success: function(){                   
                                                              jq('#someday_maybe_<?php echo $someDayMaybe->getId(); ?>').fadeOut(500);
                                                              }, 
                                           error: function(){
                                                           
                                                            }
                                           });
				  
				  
				  
					jq(this).dialog('close');
				},
				'<?php echo __("no"); ?>': function() {
					jq(this).dialog('close');
				}
			}
		});

          });

          jq('.delete_<?php echo $someDayMaybe->getId()?>').click(function(){
	  
	    jq("#dialog-confirm-delete").dialog({
			resizable: false,
			title: '<?php echo __("delete") ?>',
			height:180,
			modal: true,
			buttons: {
				'<?php echo __("yes"); ?>': function() {
				   jq.ajax({
                                           type: "DELETE",
                                           url: "<?php echo url_for('no_actionable_item_management/delete') ?>",
                                           data: "id=<?php echo $someDayMaybe->getId(); ?>&type=SOMEDAYMAYBE",
                                           success: function(){
                                                              jq('#someday_maybe_<?php echo $someDayMaybe->getId(); ?>').fadeOut(500);
                                                              }, 
                                           error: function(){
                                                            
                                                            }
                                           });	  
			           jq(this).dialog('close');
				},
				'<?php echo __("no"); ?>': function() {
					jq(this).dialog('close');
				}
			}
		});

          });

<?php } ?>
});


</script>

<?php } catch (Exception $e) { ?> 

</table> 

<h5><?php echo __('you_have_no_action'); ?>.</h5>

<script type="text/javascript">
jq('div.dialog-msg').hide();
</script>

<?php echo $e->getMessage(); } ?>
