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

$places = array(
                'menu'=>array(       
                                array('name'=>__('process'),'url' => '@process'),
                                array('name'=>__('criterias'),'url' => null)                                
                              )             
               );
               
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('criterias'))) ?>


<div id="principal">  

                <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('manage_your_criteria');?>.</h1>
                </div>
                </div>
      
<div class="normal">      	

<div id="div-messages"></div>

<div id="advance-panel"></div>

<div id="panel-criterias" class="close-panel">
    <form method="get" action="<?php echo url_for('criteria_management/index'); ?>">
      <label for="discriminator"><strong><?php echo __('show');?></strong></label>
      <select id="filter" name="filter">
          <option value="-1">---<?php echo __('all_criterias')?>---</option>
            <?php foreach ($selections as $selector) {
                ?>

          <?php
          //@filter come from the request from the action.class.php
          $selection=null;
         
          $selection = ($filter == $selector->getDiscriminator()) ? 'selected' : '';
         
          ?>
            <option <?php echo $selection ?> value="<?php echo $selector->getDiscriminator() ?>"><?php echo ucwords(strtolower(__($selector->getDiscriminator()))) ?></option>
            <?php
            
            }
            
            ?>
        </select>
    <input class="type-button" type="submit" value="<?php echo __('search')?>"/>
  </form>
</div>

<script type="text/javascript">
jq('#advance-panel').html("");
jq('#advance-panel').html("<img src=\"/images/icons/+.gif\"><a title=\"<?php echo __('Show search panel'); ?>\" href=\"javascript:void(0)\"><?php echo __('show_advance_panel') ?></a>");
jq('#panel-criterias').hide();


jq('#advance-panel').click(function(){
  
  if (jq('#panel-criterias').hasClass('close-panel')) {
  
    jq('#panel-criterias').show();
    jq('#panel-criterias').removeClass('close-panel');
    jq('#panel-criterias').addClass('open-panel');
    jq('#advance-panel').html('');
    jq('#advance-panel').html("<img src=\"/images/icons/-.gif\"><a <a title=\"<?php echo __('Hide the search panel'); ?>\" href=\"javascript:void(0)\"><?php echo __('hide_advance_panel') ?></a>");
    
    
  } else {
  
    jq('#panel-criterias').hide();
    jq('#panel-criterias').addClass('close-panel');
    jq('#panel-criterias').removeClass('open-panel');
    jq('#advance-panel').html('');
    jq('#advance-panel').html("<img src=\"/images/icons/+.gif\"><a <a title=\"<?php echo __('Show search panel'); ?>\" href=\"javascript:void(0)\"><?php echo __('show_advance_panel') ?></a>");
  
  
  }
  
});
  
</script>

<?php
//check if exist any result
if (count($criteriasPager) > 0) {
?>

<div id="criteria-list">
  <?php include_partial('criteria_list',array('criteriasPager'=>$criteriasPager,'filter'=>$filter,'TypeCriteriaCount'=>$TypeCriteriaCount))?>
</div>


<?php } else { ?>
<?php echo __('no_criterias_found')?><br/>
<?php } ?>

</div>

</div>


<script type="text/javascript">

<?php if ($sf_user->hasFlash('mensajes')): ?>
  renderMessages('<?php echo __($sf_user->getFlash("mensajes")) ?>','success');
<?php endif; ?>

</script>

