<div class="etiqueta"><?php echo __('project_state_id') ?>:</div>

<select id="project_state" name="project_state" >

  <?php  foreach($projectState as $projectStateItem){  ?>
        
      <option value="<?php echo $projectStateItem->getId();?>"><?php echo $projectStateItem->getType();?></option>
  <?php }  ?>
      
 </select>

