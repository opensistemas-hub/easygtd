
<div class="content-marker"></div>
  <div id="content-general-with-mark" class="float-left"><h3><?php echo __('Transforms this action to make it some day') ?>.</h3>
            	<br/>
            	<br/>
            	


<?php echo form_tag('doing_work/save_some_day_maybe',array('id'=>'form-to-someday'))?>



<input type="hidden" name="action_id" id="action_id" value="<?php echo $action->getId()?>">
<input type="hidden" name="ref" id="ref" value="<?php echo $ref ?>" />

<table width="350" border="0">
  <tr>
    <td width="101"  align="left"><?php echo __('name')?></td>
    <td width="83"  align="left"><?php  echo $action->getName();?></td>
  </tr>
  <tr>
    <td  align="left"><?php echo __('description'); ?></td>
    <td  align="left"><?php  echo (strlen($action->getDescription())>0)?$action->getDescription():__('this_action_do_not_have_description');?></td>
  </tr>
  <tr>
    <td  align="left"><?php echo __('do_before'); ?></td>
    <td  align="left"><?php echo $form['calendar']->render(array('onFocus'=>'blur()','value'=>'','id'=>'calendar','class'=>'datepicker'));?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" value="<?php echo __('save'); ?>"/></td>
  </tr>
</table>



</form>
</div>
<script type="text/javascript">
   jq(function(){

  <?php 
#calculate today
list($year,$month,$date) = explode('-',date('Y-m-d'));
  ?>

    jq('input.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','Mar','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			duration: 'fast',
			minDate: new Date(<?php echo $year ?>, <?php  echo ($month-1)?>, <?php echo $date ?>),
			showOn: 'button',
			buttonImage: '/images/icons/agenda.gif',
			buttonImageOnly: true

		});
    });
  jq('#form-to-someday').ajaxForm(function(){
    
    jq('#tree-render').load('<?php echo url_for("project_management/tree_ajax") ?>',{limit:30},function(responseText,textStatus,req){
      
                      if (textStatus == 'error') {
                          alert('No se ha podido actualizar la lista');
                          }
    
                      });
                      
    jq.fancybox.close();
    
  })  
    
</script>
