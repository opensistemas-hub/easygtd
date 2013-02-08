  <select id="priority" name="priority">
  <?php
    $selected = '';
    foreach($priorities as $priorityItem){
    
    if(isset($priority) && is_object($priority)){
    
      if( $priority->getId() == $priorityItem->getId() ) {
        
        $selected = 'selected';
        
      } else {
        
        $selected = '';
        
      }
      }
     ?>
      <option <?php echo $selected ?> value="<?php echo $priorityItem->getId();?>"><?php echo $priorityItem->getValue();?></option>
  <?php } ?>
  </select>
