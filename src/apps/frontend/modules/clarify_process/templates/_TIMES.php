<select id="time" name="time" >
<?php    
  $selected = '';
   foreach($times as $timeItem){
    //select if exist a time from the update
    if(isset($timeAvailable) && is_object($timeAvailable)){
        if( $timeAvailable->getId() == $timeItem->getId() ){

          $selected = 'selected';

        } else {
          
          $selected = '';
        
        }
    
    }
?>
      <option <?php echo $selected ?> value="<?php echo $timeItem->getId();?>"><?php echo $timeItem->getValue().' '.__($timeItem->getUnit());?></option>

<?php } ?>
  </select>  
