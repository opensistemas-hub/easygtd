<?php 
$count=0;
$no_actionable_counter=null;
$action_counter=null;
//get a project id
  foreach($project->getProjectNoActionableActions() as $search){

    $count++;

  }

//I take the counter for a number for action in a project and the relationship with no actionable project
$project_id = $project->getId();

$no_actionable_counter=$count;
$action_counter=count($actions);

?>
<span class="project_title">Project: <?php echo $project->getName(); ?></span>



<div class="project_actions">
<?php 
///cuento las relaciones existentes y las envio al parcial _action




foreach ($actions as $action) { ?>

  <?php 
  
  include_partial('action', array('action' => $action,'project_id'=>$project_id,'no_actionable_counter'=>$no_actionable_counter,'action_counter'=>$action_counter)); 
  
  
  
  ?>

<?php } ?>

<?php echo link_to('Add action to this project','doing_work/create_next_action_project?project_id='.$project->getId().'&ref=doing_work')?>
</div>
