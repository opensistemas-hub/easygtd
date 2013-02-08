<?php 
$url = null;
foreach ($bookmarks as $bookmark) {
  
  
  switch ($bookmark->getType()) {
    case 'STUFFS_MARK':
      $url = 'stuff_management/show'; 
      break;
    case 'NEXT_ACTIONS_MARK':
      $url = 'doing_work/show';
      break;
    case 'SOME_DAYS_MARK':
      $url = 'no_actionable_item_management/show?ref=SOMEDAYMAYBE';#ACTION_ID
      break;
    case 'REFERENCES_MARK':
      $url = 'no_actionable_item_management/show?ref=REFERENCE';#ACTION_ID
      break;   
   
  
  }?>
    
    <?php echo link_to($bookmark->getValue(),$url);?> <br/>

<?php
  }
?>
