<?php 
$places = array(
                'menu'=>array(                                
                                array('name'=>__('process'),'url' => null)
                              )             
              );
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('process'))) ?>

<div id="principal">  

  <div class="content-with-shade">
    <div class="content-general-with-mark">
      <h1><?php echo __('edit_action'); ?></h1>
    </div>
  </div>

<div class="normal">

<?php include_partial('form_actionable',array(
                      'form'=>$form,
                      'action'=> isset($action) ? $action : null ,
                      'stuff'=> isset($stuff) ? $stuff : null,
                      'reference'=> '',
                      'projects'=> isset($projects) ? $projects : null,
                      'contexts'=>$contexts,
                      'times'=>$times,
                      'energies'=>$energies,
                      'priorities'=>$priorities,
                      'typeNextActions'=>$typeNextActions,
                      'archivo' => $archivo,
                      'timeAvailable'=> isset($timeAvailable) ? $timeAvailable : null,
                      'energy' => isset($energy) ? $energy : null,
                      'priority'=> isset($priority) ? $priority : null ,
                      'contextCriterias'=> isset($contextCriterias) ? $contextCriterias : null,
                      'delegateto'=> isset($delegateto) ? $delegateto : null,
                      'followuptime'=> isset($followuptime) ?$followuptime : null,
                      'followupdate'=> isset($followupdate) ?$followupdate: null,
                      'todoindatestart'=> isset($todoindatestart) ? $todoindatestart: null,
                      'todoindateend'=> isset($todoindateend) ?$todoindateend: null,
                      'todoinhourstart'=> isset($todoinhourstart) ?$todoinhourstart: null,
                      'todoinhourend'=> isset($todoinhourend) ?$todoinhourend: null,
                      'duedate'=> isset($duedate) ? $duedate: null,
                      'projectsValue'=> isset($projectsValue) ? $projectsValue: null,
                      'ref'=> isset($ref) ? $ref: null
                      ));
 ?>
</div>
</div>
