<?php if ($nextActionAttachments->count() > 0) { ?> 
   <ul class="attachments">
          <?php
           foreach($nextActionAttachments as $nextAttachment){ ?>
             <li id="action_attachments_<?php echo $nextAttachment->getId() ?>">
             <?php
                    $attach = explode('_',$nextAttachment->getValue());
                    $cont = strlen($attach[0]);
                    $attachName = substr($nextAttachment->getValue(),$cont+1);
             
                    echo image_tag('icons/attachment.jpeg',array('class'=>'', 'alt' => ''));echo link_to($attachName,'@download_next_action_attachment?next_action_attachment_id='.$nextAttachment->getId(), array('target' => '_blank'));

             ?>
             </li>
           <?php }?>
     </ul>
<?php } ?>
