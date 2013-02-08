<div class="content-general-with-mark">
  <h1> <?php echo __('detail_stuff')?></h1>
</div>

<div class="normal">
  <div class="etiqueta"><?php echo __('title')?>: </div><div class="valor"><?php echo $stuff->getName(); ?></div>
  <div class="clear"></div>
  <div class="etiqueta"><?php echo __('description')?>: </div><div class="valor"><?php echo ($stuff->getDescription() == '') ? __('this_action_do_not_have_description') : $stuff->getDescription() ; ?></div>
  <div class="clear"></div>
  <div class="etiqueta"><?php echo __('attachments')?>: </div>
  <div class="valor"> 
     <?php if ($stuff->getStuffAttachments()->count() > 0) { ?>
       <ul>
         <?php foreach($stuff->getStuffAttachments() as $stuffAttachment ) { ?>
    
                     <li id="attachment_<?php echo $stuffAttachment->getId(); ?>">
                         <?php
                   
                          $attach = explode('_',$stuffAttachment->getValue());
                          $cont = strlen($attach[0]);
                          $attachName = substr($stuffAttachment->getValue(),$cont+1);  ?>

                          <?php echo image_tag('icons/+.gif');?><?php echo link_to($attachName,'@download_stuff_attachment?stuff_attachment_id='.$stuffAttachment->getId(), array('target' => '_blank')) ; ?>
                           
                     </li>
                    
         <?php } ?>
       </ul>
    <?php } else { ?> 
      <?php echo __('no_attachments')?>
    <?php } ?>
  </div>
  <div class="clear"></div>
</div>
<br/>




