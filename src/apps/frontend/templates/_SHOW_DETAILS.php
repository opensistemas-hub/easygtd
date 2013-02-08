<?php
    $id = "";
    $name = "";
    $description = "";
    $options = false;
    $attachments = array();

    if (isset($someDayMaybe)){
      $attachments = $someDayMaybe->getNoActionableItemAttachments();
      $name = "";
      $description = $someDayMaybe->getDescription();
      $id = $someDayMaybe->getId();
    }

    if (isset($reference)){
      $attachments = $reference->getNoActionableItemAttachments();
      $name = $reference->getName();
      $description = $reference->getDescription();
      $id = $reference->getId();
      $options = true;
    }

?>

<li id="detail_link_<?php echo $id; ?>" style="padding:5px; margin-left:50px;">
  <ul class="float-left">
    <?php   

    echo '<li>'.$name.' '.$description.'</li>';

    $countItemNoActionable = count($attachments);

    if ($countItemNoActionable > 0) { ?>

      <?php foreach ($attachments as $attachment) { ?>
    
                    <li id="attachment_<?php echo $attachment->getId(); ?>">
                         <?php

                          $attach = explode('_',$attachment->getValue());
                          $cont = strlen($attach[0]);
                          $attachName = substr($attachment->getValue(),$cont+1);  ?>              

                          <?php echo image_tag('icons/+.gif');?><?php echo link_to($attachName,'no_actionable_item_management/download_attachment?attachment_id='.$attachment->getId(), array('target' => '_blank')) ; ?>

                     </li>

      <?php } ?>      
    <?php } ?>

  </ul>
  <?php if ($options) { ?>
    <div class="float-right" style="margin-right:5px;">
     <?php echo link_to(image_tag('icons/icon_edit.gif', array('alt' => '')),'no_actionable_item_management/edit?id='.$id,array('class'=>'modal', 'title' => __('edit'))); ?>
     <?php echo '<a id="delete_url_reference_'.$id.'" href="javascript:void(0);">'.image_tag('icons/dot-red.gif', array('alt' => '')).'</a>'; ?>
    </div>
  <?php } ?>
  <div class="clear"></div>
</li>


     <script type="text/javascript">

     jq('#dialog-confirm-reference').hide();
     jq('#delete_url_reference_<?php echo $id; ?>').click(function(){
		     jq("#dialog-confirm-reference").dialog({
                 resizable: false,
                 title: 'Elimina',
                 height:180,
                 modal: true,
                 buttons: {
                 '<?php echo __("yes")?>': function() {
                                                jq.ajax({
                                                        type: "DELETE",
                                                        url: "<?php echo url_for('no_actionable_item_management/delete'); ?>",
                                                        data: "id=<?php echo $id; ?>",
                                                        success: function(){
                                                                           jq('#detail_link_<?php echo $id; ?>').fadeOut(500);
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

     </script>
