<?php

$places = array(
                'menu'=>array(
                                array('name'=>__('Organizing'),'url' => '@project'),
                                array('name'=>__('project'),'url' => null)
                              )
               );

?>
<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('project'))) ?>

<div id="principal">               

                <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('manage_your_project'); ?></h1>
                </div>
                </div>

<div id="list_project_state" class="normal" style="padding:5px; margin-left:100px">
    
      <?php  //include_partial('PROJECT_STATE', array('projectState' => $projectState))?>
   
</div>


  <div id="list-project" class="normal">

    <?php if (count($projectsPager) > 0) {
      include_partial('projects_list',array('projectsPager'=>$projectsPager,'noProjectNextActions' => $noProjectNextActions));
      } else { ?>
 <h5><?php echo __('no_project_found')?></h5>
<?php } ?>

  </div>
</div>









