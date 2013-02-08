<div class="action_informations">
<?php 
  foreach ($informations as $nextActionInfo) {
    if (strlen($nextActionInfo->getValue()) > 0) include_partial($nextActionInfo->getType(), array('nextActionInfo' => $nextActionInfo));
  } 
?>
</div>
<div class="clear"></div>

