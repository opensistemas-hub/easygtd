<?php

try {
//Armo la coleeción por que la fecha la muestro siempre sin necesidad del "ver más":
$informationsWithOutDates = array();
$informationsWithDates = array();

foreach($informations as $information) {
  if (!is_object($information)) throw new Exception();
  switch($information->getType()) {
    case 'DUE_DATE':
    case 'FOLLOW_UP_DATE':
    case 'FOLLOW_UP_TIME':
            $informationsWithDates[] = $information;
            break;
    
    default:
            $informationsWithOutDates[] = $information;
            break;
            
  }
}

echo '<div class="tab_info" id="details_action_id_'.$action->getId().'">'; 
  //La descripción siempre visible y los adjuntos
  //Si no hay descripción le pongo "Sin descripcion" 
  echo (strlen($action->getDescription()) == 0) ? '' : $action->getDescription();
  echo "<ul>";
    include_partial('global/get_information_render',array('informations'=>$informationsWithDates,'action' => $action));   
    include_partial('global/get_information_render',array('informations'=>$informationsWithOutDates,'action' => $action));    
    include_partial('global/criterias',array('criterias' => $action->getNextActionCriterias())); 
  echo "</ul>";
  echo '<div class="clear"></div>';
    include_partial('global/attachment',array('nextActionAttachments' => $action->getNextActionAttachments()));
echo '</div>'; 
} catch (Exception $e) {

}
?>
