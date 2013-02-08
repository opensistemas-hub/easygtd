<div id="criteria_form">

<div class="etiqueta"><?php echo __('Fecha') ?>: </div>
<div class="valor">
   <span id="datepicker_label"></span>
   <input id="due_date" class="fecha datepicker-unix" name="date-criteria" type="hidden" value="" />   
</div>
<div class="clear"></div>

<div class="etiqueta"><?php echo __('context') ?>: </div>
<div class="valor">
  <select id="context_id">
    <option value="-1">-- <?php echo __('all');?> --</option>
    <?php foreach($contextCriterias as $ncriteria){?>
    <option value="<?php echo $ncriteria->getId(); ?>"><?php echo $ncriteria->getValue(); ?></option>
    <?php } ?>
  </select>
</div>
<div class="clear"></div>

<div class="etiqueta"><?php echo __('to_be_done_in') ?>: </div>
<div class="valor">
  <select id="time_id">
    <option value="-1">-- <?php echo __('all');?> --</option>
    <?php foreach($timeCriterias as $ncriteria){?>
    <option value="<?php echo $ncriteria->getId()?>"><?php echo $ncriteria->getValue(); ?> <?php echo __($ncriteria->getUnit()) ?></option>
    <?php } ?>
  </select>
</div>
<div class="clear"></div>

<div class="etiqueta"><?php echo __('energy_needed')?>: </div>
<div class="valor">
  <select id="energy_id" name="energy-criteria">
    <option value="-1">-- <?php echo __('all');?> --</option>
    <?php foreach ($energyCriterias as $ncriterias) {?>
    <option value="<?php echo $ncriterias->getId()?>"><?php echo $ncriterias->getValue() ?></option>
    <?php } ?>
  </select>
</div>
<div class="clear"></div>

<div class="etiqueta"><?php echo __('priority') ?>: </div>
<div class="valor">
  <select id="priority_id" name="priority-criteria">
    <option value="-1">-- <?php echo __('all');?> --</option>
    <?php foreach ($priorityCriterias as $ncriterias) {?>
    <option value="<?php echo $ncriterias->getId()?>"><?php echo $ncriterias->getValue() ?></option>
    <?php } ?>
  </select>
</div>
<div class="clear"></div>

<div class="etiqueta"><?php echo __('Show done actions')?>: </div>
<div class="valor">
  <input type="checkbox" id="done_checkbox" class="checkbox" name="done" value="done"/>
</div>
<div class="clear"></div>

<div class="etiqueta"></div>
<div class="boton">
  <input type="button" id="search_next_actions" name="search_next_actions" value="<?php echo __('search'); ?>"/>
</div>
<div class="clear"></div>

<div class="etiqueta"></div>
<div class="valor">
  <?php echo link_to(__('save_search'),'doing_work/newSavedSearch', array('class'=>'modal', 'id'=>'saved_search')); ?>
  |       
  <?php echo link_to(__('edit_criterias'),'criteria_management/index'); ?>
</div>
<div class="clear"></div>

</div>

<script type="text/javascript">
  jq('#saved_search').bind('click',function(){
    //Excepción: Si está seleccionada la opción "Hoy", el dueToday = 1, sino pongo la fecha
    if (jq('#focus_today').hasClass('selected')) dueToday = 1;
    jq('#saved_search').attr("href", 'doing_work/newSavedSearch?done=' + done +'&search_id=' + searchId + 'project_id=' + projectId + '&only_date=' + onlyDate + '&due_today=' + dueToday +'&context_id=' + context + '&time_id=' + time + '&energy_id=' + energy + '&priority_id=' + priority + '&type_id=' + type);
  });

  jq('input.datepicker-unix').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: '@',
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			duration: 'fast',
			showOn: 'button',
			buttonImage: '/images/icons/agenda.gif',
			buttonImageOnly: true, 
                        onSelect: function(dateText, inst) { 
                           onDueDateChange();                                                      
                          }
  });

  

</script>

