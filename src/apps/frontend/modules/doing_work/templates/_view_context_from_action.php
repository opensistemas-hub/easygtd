<?php
#TYPE: PARTIAL
#RENDER CRITERIAS ON DETAILS IN DOING WORK INDEX

?>
<?php

$list = '';

foreach($criterias as $key =>$criteria) {
  
 $node = $key+1;
 
 $dot = ($node == 1)?'':', ';
 

  $list.= $dot.$criteria->getCriteria()->getValue().' ';
 
 
  
   
}
echo $list;

?>


