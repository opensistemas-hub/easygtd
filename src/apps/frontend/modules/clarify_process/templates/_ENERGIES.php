<select id="energy" name="energy" >
  <?php
  //dejo vacio el selected
  $selected = '';
    foreach($energies as $energyItem){
    //si el energy es igual al que esta registrado asignarlo como seleccionado
    if(isset($energy) && is_object($energy)){
      if( $energy->getId() == $energyItem->getId() ){
      
        $selected = 'selected';
      
      } else {
      
        $selected = '';
      
      }
      }
    
    ?>
      <option <?php echo $selected; ?> value="<?php echo $energyItem->getId();?>"><?php echo $energyItem->getValue();?></option>
  <?php } ?>
  </select>
