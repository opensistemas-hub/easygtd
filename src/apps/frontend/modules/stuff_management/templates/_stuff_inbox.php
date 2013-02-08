<div id="dialog-confirm"><?php echo __('Are you sure you want to remove this stuff?') ?></div>

<table class="list"> 
  <tbody>
    <?php foreach ($stuffsPager->getResults() as $stuff): ?>
    <tr id="stuff_inline_<?php echo $stuff->getId() ?>" >     
      <td>
        <div class="info_wrapper"> 
        <div class="info"> 
        <div class="info_list"> 
          <?php         
            echo link_to($stuff->getName(),'stuff_management/show_url?stuff_normalized_name='.$stuff->getNormalizedName(),array('class'=>'modal title')); 
            echo '<br/>';
            echo ($stuff->getDescription() <> "") ? $stuff->getDescription().'<br/>' : '' ;
            echo '<i>'.__('created_at').':&nbsp;'.format_date($stuff->getCreatedAt(), $sf_user->getGuardUser()->getFormatDate()).'</i>';
          ?>
          <?php if($stuff->getStuffAttachments()->count() > 0){              
                  echo '<font>'.$stuff->getStuffAttachments()->count().' '. __('attachments').'</font>';
                }
          ?>
        </div>     
        <div class="info_options">
           <?php echo link_to(image_tag('icons/icon_edit.gif', array('alt' => '')),'stuff_management/edit?id='.$stuff->getId(),array('class'=>'modal', 'title' => __('edit') ,'id' => 'edit_img_'.$stuff->getId())); ?> 
           <a class="delete_<?php echo $stuff->getId() ?>" title="<?php echo __('delete'); ?>" id="delete_img_<?php echo $stuff->getId()?>" href="javascript:void(0)" ><?php echo image_tag('icons/dot-red.gif',array('', 'alt' => ''));?></a>      
        </div>
        <div class="clear"></div>
        </div>
        </div>
      </td>
  </tr>   
  <?php endforeach; ?>
  </tbody>
</table>

  <div style="clear:left; text-align:center;" class="paginator">
    <?php  echo pager_navigation($stuffsPager, url_for('stuff_management/index'.html_entity_decode($urls)),'stuff-content','ajax=false') ?>
  </div>
   
<script type="text/javascript">

jq(function(){

jq('#dialog-confirm').hide();
  
<?php foreach ($stuffsPager->getResults() as $stuff): ?>
  
  jq('.delete_<?php echo $stuff->getId()?>').click(function(){
    jq("#dialog-confirm").dialog({
			resizable: false,
			title: '<?php echo __("delete")?>',
			height:180,
			modal: true,
			buttons: {
				'<?php echo __("yes")?>': function() {
                                                                       jq.ajax({
                                                                         type: "delete",
                                                                         url: "<?php echo url_for('stuff_management/delete') ?>",
                                                                         data: "id=<?php echo $stuff->getId() ?>",
                                                                         success: function(){
                                                                                            jq('#stuff_inline_<?php echo $stuff->getId() ?>').fadeOut(500);
                                                                                            resize_blocks();
                                                                                            corner_blocks();                                                                                            
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
  });  
        
<?php endForeach; ?>
  
});

</script>
