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
 
 

