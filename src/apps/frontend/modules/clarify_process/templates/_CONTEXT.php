<?php
  if(!isset($contextCriterias)){
    $contextCriterias = null;
  }
?>
<div id="contexts">
  <select id="context[]" name="context[]" size=5 multiple><br/>
  <?php
  
    foreach($contexts as $key => $context){?>
     
      <option
       <?php 
       if(is_null($contextCriterias)){

          if ( $key == 0 ){
            echo 'selected="selected"';
          }
          
       } else {
          foreach ($contextCriterias as $row){
            if($row->getId() == $context->getId()){
              echo 'selected="selected"';
            }else{
              echo '';
            }
          }
          
          }
        
         ?>
      
       value="<?php echo $context->getId() ?>"><?php echo $context->getValue(); ?></option>
       
        <?php  }  ?>
    </select>
</div>
