<select id="project_id" name="project_id"> 
  <option value="-1"><?php echo __('no_project'); ?></option> 
   <?php foreach($projects as $projectsItem){
      $selected = '';   
      if(isset($projectsValue) and is_object($projectsValue)) {
        if( $projectsValue->getId() == $projectsItem->getId()) $selected = 'selected';
     }     
   ?>   
   <option <?php echo $selected; ?> value="<?php echo $projectsItem->getId();?>"><?php echo $projectsItem->getName();?></option> -->
  <?php }  ?>  
</select> 


