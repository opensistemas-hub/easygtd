<?php
#type:partial
#description: render attachment for some action or stuff on _form_actionable.php
?>
<div id="action_attachments_<?php echo $attachment->getId() ?>" class="attachment-list">
<?php 
$attach = explode('_',$attachment->getValue());
                          $cont = strlen($attach[0]);
                          $attachName = substr($attachment->getValue(), $cont + 1);    

                          try {
                             if (is_object($attachment->getNextAction())) 
                               $id = 'next_action_attachment_id';                
                          } catch (Exception $e) {
                               $id = 'stuff_attachment_id';
                          }
                               
                          echo link_to($attachName,'clarify_process/download_attachment?'.$id.'='.$attachment->getId(), array('target' => '_blank'));

?>
    
<span style="position:relative;left:9%;" id="delete_attachment_<?php echo $attachment->getId() ?>"><a href="javascript:void(0)"><?php echo __('delete')?>&nbsp;<?php echo image_tag('icons/dot-red.gif',array('height'=>'10px','width'=>'10px')) ?></a></span>

</div>


<script type="text/javascript">

jq('#delete_attachment_<?php echo $attachment->getId(); ?>').hide();
jq('#action_attachments_<?php echo $attachment->getId() ?>').bind('mouseover',function() {
  jq('#delete_attachment_<?php echo $attachment->getId(); ?>').show();
  }).bind('mouseleave', function(){  
                                  jq('#delete_attachment_<?php echo $attachment->getId(); ?>').hide();
                                  }
  );

</script>
