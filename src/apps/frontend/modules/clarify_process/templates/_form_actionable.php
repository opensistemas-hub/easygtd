<?php

$actionName = null;
$actionId = null;
$actionDescription = null;

$reference_action = null;
$kind_of_action = null;


$type = null;

if(is_object($action)) {
  $actionName = $action->getName();
  $actionId = $action->getId();
  $actionDescription = $action->getDescription();
  $type = $action->getType();
} 

if(is_object($stuff)) {
  $actionName = $stuff->getName();
  $actionId = $stuff->getId();
  $actionDescription = $stuff->getDescription();
} 

$selected = null;
  
?>

<div class="hide-dialog" id="dialog-confirm" title="<?php echo __('Confirmation')?>">
	<p><?php echo __('Are you sure you want to delete this attachment') ?>.</p>
</div>

<div class="form_actionable">
  <div class="normal">
    <?php echo form_tag('clarify_process/save_actionable',array('name'=>'create_actionable','id'=>'create_actionable','enctype'=>'multipart/form-data')); ?>
    <!-- Detect reference or action id or type of action-->
    <?php if (isset($action)) { ?>
      <input type="hidden" name="action_id" id="action_id" value="<?php  echo $actionId;  ?>" />
    <?php } ?>

    <?php if (isset($stuff)) { ?>
      <input type="hidden" name="stuff_id" id="stuff_id" value="<?php  echo $actionId;  ?>" />
    <?php } ?>

    <div class="etiqueta"><?php echo __('action')?>:</div><div class="valor"><?php echo $form['name']->render(array('class'=>"required campo_de_texto",'value' => $actionName,'id'=>'name')); ?></div>
    <div class="clear"></div>  

    <div class="etiqueta"><?php echo __('description') ?>:</div><div class="valor"><textarea name="description" id="description_text" class="campo_de_texto"><?php echo $actionDescription; ?></textarea></div>
    <div class="clear"></div>  

    <div class="etiqueta"><?php echo __('attachments') ?>:</div>
    <div class="valor">
      <?php include_partial('SHOW_ATTACHMENTS',array('ref'=>'','action'=>$action, 'stuff' => $stuff))?>
      <br/><br/>
      <?php include_partial('ADD_ATTACHMENT_AJAX', array('archivo' => $archivo))?>
    </div>
    <div class="clear"></div>     <br/>


    <div class="etiqueta"><?php echo __('project') ?>:</div>
     <div class="valor full projects" id="project_list">
      <?php
       if (isset($projectsValue)) {
           include_partial('global/PROJECTS',array('projects'=>$projects,'projectsValue'=>$projectsValue)); //cuando se venga de un nextAction
       }else{
            include_partial('global/PROJECTS',array('projects'=>$projects)); //cuando se venga de un stuff
            }
      ?>
     </div>



    <div class="etiqueta"><?php echo __('the_next_action_will_be') ?>:</div>
    <div class="valor">
    <?php include_partial('NEXT_ACTION',array('form' => $form,
                                              'typeNextActions'=>$typeNextActions,
                                              'type'=>$type,
                                              'hours'=> array(),
                                              'action' => isset($action) ? $action : null ,
                                              'timeAvailable' => isset($timeAvailable) ? $timeAvailable : null ,
                                              'times'=>$times, 'energies'=>$energies,
                                              'energy'=>isset($energy) ? $energy : null,
                                              'priorities'=>$priorities,
                                              'priority'=>isset($priority) ? $priority : null,
                                              'delegateto'=>isset($delegateto) ? $delegateto : null,
                                              'followupdate'=>isset($followupdate) ? $followupdate : null,
                                              'followuptime'=>isset($followuptime) ? $followuptime : null,                                              
                                              'todoinhourstart'=>isset($todoinhourstart) ? $todoinhourstart : null,
                                              'todoinhourend'=>isset($todoinhourend) ? $todoinhourend : null,
                                              'todoindatestart'=>isset($todoindatestart) ? $todoindatestart : null,
                                              'todoindateend'=>isset($todoindateend) ? $todoindateend : null,
                                              'duedate'=>isset($duedate) ? $duedate : null,
                                                )); ?></div>
    <div class="clear"></div>  

    <div class="etiqueta contexts"><?php echo __('This action makes he') ?>:<br/>
      <?php echo link_to(__('edit_criterias'),'criteria_management/index'); ?>
    </div>
    <div class="valor full contexts">
      <?php if (isset($contextCriterias)) {
              include_partial('CONTEXT',array('contexts'=>$contexts,'contextCriterias'=>$contextCriterias));
            } else {
              include_partial('CONTEXT',array('contexts'=>$contexts));  
            } ?>
    </div>
    <div class="clear contexts"></div> 

   <br/>
      <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
      <div class="clear"></div>  

    </form>
  </div>
</div>  

<script type="text/javascript">

  jq('div.hide-dialog').hide();  
  activateDoASAP();
 
  var type = "<?php echo $type; ?>";
  switch(type) {
    case "DO_IT_NOW": activateDoItNow();
      break;
    case "DO_ASAP": activateDoASAP();
      break;
    case "DELEGATED": activateDelegated();
      break;
    case "SCHEDULED": activateScheduled();
      break;
  }
 
jq('#next_action_DO_IT_NOW').click(function(){
  activateDoItNow();
});


function activateDoItNow(){

  jq('#forms-do-asap').hide();
  jq('#forms-delegate_to').hide();
  jq('#forms-scheluded').hide();   
  jq('.contexts').show();
 
  jq('#delegate_to').removeClass('required');
  jq('#calendar_delegated').removeClass('required');
  jq('#calendar_scheluded_start').removeClass('required');
}

jq('#next_action_DO_ASAP').click(function(){
  activateDoASAP();
});

function activateDoASAP(){
  jq('.contexts').show();
  jq('#forms-do-asap').show();
  jq('#forms-delegate_to').hide();
  jq('#forms-scheluded').hide();

  jq('#delegate_to').removeClass('required');
  jq('#calendar_delegated').removeClass('required');
  jq('#calendar_scheluded_start').removeClass('required');
  
}

jq('#next_action_DELEGATED').click(function(){
  activateDelegated();
});

function activateDelegated(){

  jq('.contexts').show();
  jq('#forms-do-asap').hide();
  jq('#forms-delegate_to').show();  
  jq('#forms-scheluded').hide();

  jq('#delegate_to').addClass('required');
  jq('#calendar_delegated').addClass('required');
  jq('#calendar_scheluded_start').removeClass('required');

}

jq('#next_action_SCHEDULED').click(function(){
  activateScheduled();
});

function activateScheduled(){

  jq('.contexts').show();
  jq('#forms-do-asap').hide();   
  jq('#forms-delegate_to').hide();
  jq('#forms-scheluded').show();

  jq('#calendar_delegated').removeClass('required');
  jq('#calendar_scheluded_start').addClass('required');
  
}

<?php list($year,$month,$date) = explode('-',date('Y-m-d')); ?>

    jq('input.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			duration: 'fast',
			minDate: new Date(<?php echo $year ?>, <?php  echo $month -1; ?>, <?php echo $date ?>),
			showOn: 'button',
			buttonImage: '/images/icons/agenda.gif',
			buttonImageOnly: true, 
                        onSelect: function(dateText, inst) { 
                           
                          }
		}).addClass('float-left');

    jq('input.datetimepicker').datetimepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			duration: 'fast',
			minDate: new Date(<?php echo $year ?>, <?php  echo $month -1; ?>, <?php echo $date ?>),
			showOn: 'button',
			buttonImage: '/images/icons/agenda.gif',
			buttonImageOnly: true, 
                        onSelect: function(dateText, inst) { 
                           
                          },
                        currentText: 'Ahora',
                        closeText: 'Ok',
                        timeText: 'Hora',
                        hourText: 'Hora',
                        minuteText: 'Minutos',
                        secondText: 'Segundos',
		}).addClass('float-left');



jq("#create_actionable").validate({});

jq('#create_actionable').ajaxForm({
       // dataType identifies the expected content type of the server response 
        dataType:  "xml",  
        // success identifies the function to invoke when the server response 
        // has been received 
        success:   function(responseXML) {
           var status = jq('status', responseXML).text(); 
           if (status == 'success') {
             renderMessages("<?php echo __('clarify_ok'); ?>","success");
             <?php if (isset($ref)) { ?> 
               setTimeout("window.location.href = '<?php echo url_for('@'.$ref); ?>'", 2000);   
               return;
             <?php } ?>                  
           }
           if (status == 'error') {
             var message = jq('message', responseXML).text(); 
             renderMessages(message,'error');
           } 
        }
      }); 
<?php

$attachments = array();
$ref = '';

if (is_object($action)){
  $attachments = $action->getAttachments();
}

if (is_object($stuff)){
  $attachments = $stuff->getAttachments();
}

foreach($attachments as $attachment){ ?>
  jq('#delete_attachment_<?php echo $attachment->getId() ?>').click(function () {
  jq("#dialog-confirm").dialog({
			resizable: false,
			height:180,
			modal: true,
			buttons: {
				'<?php echo __('yes'); ?>': function() {				  
                                                                       jq(this).dialog('close');
                                                                       delete_attachment();					
				},
				'<?php echo __('no'); ?>': function() {
					jq(this).dialog('close');
				}
			}
		});

  function delete_attachment() {
    jq.ajax({
            type: "POST",
            url: "<?php echo url_for('clarify_process/delete_attachment') ?>",
            <?php if (isset($action)) { ?>
            data: "next_action_attachment_id=<?php echo $attachment->getId(); ?>",
            <?php } ?>
            <?php if (isset($stuff)) { ?>
            data: "stuff_attachment_id=<?php echo $attachment->getId(); ?>",
            <?php } ?>            
            success: function(){
                               jq('#action_attachments_<?php echo $attachment->getId();?>').fadeOut(1000);
                               },
            error: function(){
                             }   
            });
  } 
  }); 
<?php } ?>
 
</script>

