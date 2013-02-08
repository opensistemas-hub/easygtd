<?php

$attachments = array();

if (is_object($action)){
  $attachments = $action->getAttachments();
}

if (is_object($stuff)){
  $attachments = $stuff->getAttachments();
}

$countNextAction = count($attachments);

if ($countNextAction > 0) {
  ?> <ul> <?php
       foreach ($attachments as $attachment) { ?> 
         <li><?php include_partial('ATTACHMENT',array('attachment'=>$attachment))?></li><?php 
       }  
  ?> </ul> <?php

} else {
  echo __('this_action_do_not_have_attachment');
}
