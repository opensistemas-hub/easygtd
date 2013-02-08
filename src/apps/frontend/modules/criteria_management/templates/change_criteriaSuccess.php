<?php 

$places = array(
                'menu'=>array(
                                
                                array('name'=>__('criterias'),'url' => 'criteria_management/index'),
                                array('name'=>__('Reassign'),'url'=> null)
                              )             
               );
               
?>

<?php include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('reallocation'))) ?>

<div id="principal">  

                <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('Reassign').'&nbsp;'.$info->getValue().' '.$info->getUnit().' '; ?><?php echo __('to a new CRITERIA of the same type');?>.</h1>
                </div>
                </div>

<div class="normal">

<?php echo form_tag('criteria_management/save_change_criteria'); ?>

<input type="hidden" name="criteria_id" id="criteria_id" value="<?php echo $info->getId() ?>" />

<select id="new_criteria_id" name="new_criteria_id">
<?php foreach ($criterias as $criteria){ ?>
  
     <option value="<?php echo $criteria->getId() ?>"><?php echo $criteria->getValue()?></option>
  
<?php } ?>

</select>
<input type="submit" value="<?php echo __('save')?>">
</form>

</div>
</div>

