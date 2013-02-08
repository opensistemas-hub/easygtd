<?php
#type:actionView
#description:render list of criterias when update for ajax form
?>
<?php
$array=null;
$nextActionCriteriaArray=null;

#get all criterias from User and leave on Array value
foreach ($AllCriteria as $criteria) {
    
    $array[]=$criteria->getType();

}

#calls the "ValoresRepetidos" class discriminates the values and puts the main value is repeated many times
$TypeCriteriaCount=ValoresRepetidos::getInstance()->elementosRepetidos($array);

foreach ($nextActionCriterias as $nextActionCriteria) {
    foreach ($nextActionCriteria->getCriteriaNextActions() as $criteriaNextAction) {
       $nextActionCriteriaArray[] = $criteriaNextAction->getCriteria()->getValue();
    }
}

?>

<?php
//check if exist any result
if (count($criteriasPager) > 0) {
?>


<?php include_partial('criteria_list',array('criteriasPager'=>$criteriasPager,'filter'=>$filter,'TypeCriteriaCount'=>$TypeCriteriaCount))?>
</div>


<?php } else { ?>
<?php echo __('no_criterias_found')?><br/>
<?php } ?>

<script type="text/javascript">
jq(document).ready(function(){

  jq('.content-with-shade').css('left','0');

});
</script>
