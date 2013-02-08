<?php 
//$action->getId()
#cuento los contenidos de la informacion, en caso que sea mayor que 1 se le adjunta la clase close-element-<id> el cual escondera los elementos restantes almenos que el usuario ponga ver mas
$count = count($informations);

foreach ($informations as $key => $info) {     
    if (strlen($info->getValue()) > 0) include_partial('global/'.$info->getType(),array('value'=>$info->getValue()));      
}
?>

