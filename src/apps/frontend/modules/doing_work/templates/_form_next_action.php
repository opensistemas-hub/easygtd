<?php
$selected = null;
//in case if no exist next_action id assing
  if(!isset($nextAction)){
  
   $nextAction = null;
  
  }
  
//if no update pass to null
  if(!isset($context_value)){
    $context_value = null;
  }

//declare vars for text fields
$delegate = null;
$followupdate = null;
$followuptime = null;
$duedate = null;
$todoindateend = null;
$todoindatestart = null;
$todoinhourstart = null;
$todoinhourend = null;

  
//catch all var from update and check if exists in the same moment
if(isset($values_for_fields['delegate_to'])){
  $delegate = $values_for_fields['delegate_to'];
}

if(isset($values_for_fields['followupdate'])){
  $followupdate = $values_for_fields['followupdate'];
}

if(isset($values_for_fields['followuptime'])){
  $followuptime = $values_for_fields['followuptime'];
}

if(isset($values_for_fields['duedate'])){
  $duedate = $values_for_fields['duedate'];
}

if(isset($values_for_fields['todoindateend'])){
  $todoindatestart = $values_for_fields['todoindatestart'];
}

if(isset($values_for_fields['todoindateend'])){
  $todoindateend = $values_for_fields['todoindateend'];
}

if(isset($values_for_fields['todoinhourstart'])){
  $todoinhourstart = $values_for_fields['todoinhourstart'];
}

if(isset($values_for_fields['todoinhourend'])){
  $todoinhourend = $values_for_fields['todoinhourend'];
} 

?>
<?php echo form_tag('clarify_process/save_actionable',array('name'=>'create_actionable','id'=>'create_actionable','enctype'=>'multipart/form-data')); ?>
<div id="name">
<p><?php echo __('what_is_the_next_action_need_to_complete_this_stuff'); ?></p>

<input type="hidden" name="stuff_id" value="<?php if( is_object($stuff) ) { echo $stuff->getId(); } ?>" />

<input type="hidden" name="ref" id="ref" value="<?php echo $ref ?>"/>
<?php if (is_object($nextAction)) { ?>
  <input type="hidden" name="next_action_id" value="<?php echo $nextAction->getId(); ?>" />
<?php } ?>
<?php if(is_object($stuff)) { echo $form['name']->render(array('value' => $stuff->getName())); } else { $form['name']->render(); };?>
<?php
if(is_object($stuff)){
    if ($stuff->getId() != -1) {
    //inicio de modalbox
         $link_options = array(
           'title' => __('show_details'),
           'size'  => '800x450',
           'speed' => '7',
           'id'    => 'show_details'
         );
         echo light_modallink(
            __('show_details'),
            'stuff_management/show?id='.$stuff->getId().'&url=true',
            $link_options
          );
    }
    }
?>

<p><?php echo $form['description']->renderLabel() ?></p>

<?php echo $form['description']->render(array('id' => 'description_text'));?>
</div><br/>

<div id="relation-project">
<a id="relations" name="relations" href="#"><?php echo __('choose_a_project_for_this_action'); ?>.</a>
<select id="project_id" name="project_id">
    <option value="-1"><?php echo ('choose_project'); ?></option>
    <?php foreach ($projects as $project): ?>
    <option value="<?php echo $project->getId() ?>"><?php echo $project->getName() ?></option>
    <?php endForeach; ?>
</select>
<p/>
</div>
<div id="attachments">
<div id="attachments_list">
<?php

#  in case if is come from criteria is stuff, if is it doing or some other place is next action

  //stuff attachements
  if(is_object($stuff)){
  foreach($stuff->getStuffAttachments() as $stuffAttachment){?>
  <div id="action_attachments_<?php echo $stuffAttachment->getId() ?>">
<?php 
$attach = explode('_',$stuffAttachment->getValue());
                          $cont = strlen($attach[0]);
                          $attachName = substr($stuffAttachment->getValue(),$cont+1);
                                                    
                          echo link_to($attachName,'stuff_management/download_attachment?id='.$stuffAttachment->getId(), array('target' => '_blank'));

?>
    
    <div id="delete_attachment_<?php echo $stuffAttachment->getId() ?>">[Delete]</div>
    </div>
    <?php
  
  }
  }
  
  //next_action attachements
  if(isset($nextAction)){
  foreach($nextAction->getNextActionAttachments() as $nextAttachment){?>
  <div id="action_attachments_<?php echo $nextAttachment->getId() ?>">
<?php //echo substr($nextAttachment->getValue(),40,strlen($nextAttachment->getValue()));?>
<?php 

                         $attach = explode('_',$nextAttachment->getValue());
                          $cont = strlen($attach[0]);
                          $attachName = substr($nextAttachment->getValue(),$cont+1);
                                                    
                          echo link_to($attachName,'stuff_management/download_attachment?id='.$nextAttachment->getId(), array('target' => '_blank'));
                          

?>

<?php

$attachs = explode('_',$nextAttachment->getValue());
                          $conts = strlen($attachs[0]);
                          $attachNames = substr($nextAttachment->getValue(),$conts+1);
                                                    
                          echo link_to($attachNames,'stuff_management/download_attachment?id='.$nextAttachment->getId(), array('target' => '_blank'));

 ?>
    
    <div id="delete_attachment_<?php echo $nextAttachment->getId() ?>">[Delete]</div>
    </div>
    <?php
  
  }
  
  }

?>
<br/>
</div>
<div>
Attachment <a id="more_attachments">[More]</a>
</div>
<div id="action_field_attachments">
<input type="file" name="action_attachment_file_0" value="" />
</div>
</div>
<p><?php echo __('the_next_action_will_be'); ?></p>
<div id="next_actions">
<?php foreach($typeNextActions as $key => $next){ ?>
<?php
if($type == $next->getDiscriminator()) { $checked = "checked"; } else { $checked = ""; } ?>
<input <?php echo $checked; ?> type="radio" name="next_action" id="next_action_<?php echo $next->getDiscriminator(); ?>" value="<?php echo $next->getDiscriminator(); ?>" /> <?php echo $next->getMessage() ?><br/>

<?php } ?>
 


<div id="next_action_info"></div>

<?php
$hours = array( '00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30', );
?>

<?php echo $form['time_choose']->render(array('value'=>'00:00','id'=>'time_choose','name'=>'time_choose'))?>

<?php 
if(!is_null($todoinhourstart)){
echo $form['time_choose_start']->render(array('value'=>$todoinhourstart,'id'=>'time_choose_start','name'=>'time_choose_start'));

} else {
echo $form['time_choose_start']->render(array('value'=>'00:00','id'=>'time_choose_start','name'=>'time_choose_start'));
}

?>

<?php 

if(!is_null($todoinhourend)){
echo $form['time_choose_end']->render(array('value'=>$todoinhourend,'id'=>'time_choose_end','name'=>'time_choose_end'));

} else {
echo $form['time_choose_end']->render(array('value'=>'00:00','id'=>'time_choose_end','name'=>'time_choose_end'));
}

?>

<select name="time_delegated" id="time_delegated">
<?php
foreach($hours as $hour):
?>
<option value="<?php echo $hour?>"><?php echo $hour?></option>
<?php endForeach;?>
</select>

<select name="time_start" id="time_start">
<?php
foreach($hours as $hour):
?>
<option value="<?php echo $hour?>"><?php echo $hour?></option>
<?php endForeach;?>
</select>

<select name="time_end" id="time_end">
<?php
foreach($hours as $hour):
?>
<option value="<?php echo $hour?>"><?php echo $hour?></option>
<?php endForeach;?>
</select>

</div>

<div id="contexts">
  <p>The next action must be done under this criteria</p>    
  <select id="context[]" name="context[]" size=5 multiple><br/>
  <?php
  
    foreach($contexts as $key => $context){?>
     
      <option
       <?php 
       if(is_null($context_value)){
          //DO NOTHING
          if ( $key == 0 ){
            echo 'selected="selected"';
          }
          
       } else {
          foreach ($context_value as $row){
            if($row->getCriteria()->getId() == $context->getId()){
              echo 'selected="selected"';
            }else{
              echo '';
            }
          }
          
          }
        
         ?>
      
       value="<?php echo $context->getId() ?>"><?php echo $context->getValue(); ?></option>
       
        <?php  }  ?>
    </select>
</div>

<div id="times">
  <p>When I have </p><br/>
  <select id="time" name="time" >
  <?php    
  $selected = '';
    foreach($times as $time){
    //select if exist a time from the update
    if(isset($time_value)){
    if( $time_value->getCriteria()->getId() == $time->getId() ){

      $selected = 'selected';

    } else {
      
      $selected = '';
    
    }
    
    }
     ?>
      <option <?php echo $selected ?> value="<?php echo $time->getId();?>"><?php echo $time->getValue().' '.$time->getUnit();?></option>
  <?php } ?>
  </select>
  <br/>
</div>

<div id="energies">
  <p>When I am</p><br/>
  <select id="energy" name="energy" >
  <?php
  //dejo vacio el selected
  $selected = '';
    foreach($energies as $energy){ 
    //si el energy es igual al que esta registrado asignarlo como seleccionado
    if(isset($energy_value)){
      if( $energy_value->getCriteria()->getId() == $energy->getId() ){
      
        $selected = 'selected';
      
      } else {
      
        $selected = '';
      
      }
      }
    
    ?>
      <option <?php echo $selected; ?> value="<?php echo $energy->getId();?>"><?php echo $energy->getValue();?></option>
  <?php } ?>
  </select>
  <br/>
</div>

<div id="priorities">
  <p>When I am</p><br/>
  <select id="priority" name="priority">
  <?php
    $selected = '';
    foreach($priorities as $priority){
    
    if(isset($priority_value)){
    
      if( $priority_value->getCriteria()->getId() == $priority->getId() ) {
        
        $selected = 'selected';
        
      } else {
        
        $selected = '';
        
      }
      }
     ?>
      <option <?php echo $selected ?> value="<?php echo $priority->getId();?>"><?php echo $priority->getValue();?></option>
  <?php } ?>
  </select>
  <br/>
</div>
   
     <input title="<?php echo sfConfig::get('app_TITLE_ACCESS_KEY_PROCESS_SUBMIT'); ?>" accesskey="<?php echo sfConfig::get('app_ACCESS_KEY_PROCESS_SUBMIT'); ?>" id="submit" name="submit" type="submit" value="Finish" />
</form>

<script type="text/javascript">
    //add value to description textarea if exists
    
    <?php
    
      if(is_object($stuff)){
    
    ?>
    $('description_text').value='<?php echo trim($stuff->getDescription()) ?>';
   
   
   <?php } ?>
   
   
   //add attachments fields
   
    var attachments = 0;
  Event.observe('more_attachments','click', function (e) {
         if (attachments < 5) {
           $('action_field_attachments').update($('action_field_attachments').innerHTML + '<div><input type="file" name="action_attachment_file_' + Math.floor(Math.random()*1001) + '" value="" /></div>');
           attachments++;
         }
  }); 
   
   
    

    $('popupCalendar').hide();
    $('popupCalendar2').hide();
    $('popupCalendar3').hide();
    $('popupDateField4').hide();
    $('project_id').hide();
    $('time_delegated').hide();
    $('time_choose').hide();
    $('time_start').hide();
    $('time_end').hide();
    $('time_choose_start').hide();
    $('time_choose_end').hide();

  var type = "<? echo $type; ?>"; 
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

Event.observe('next_action_DO_IT_NOW','click',function(e){
  activateDoItNow();
});

function activateDoItNow(){
  $('popupCalendar').hide();
  $('popupCalendar2').hide();
  $('popupCalendar3').hide();
  $('popupDateField4').hide();
  $('time_delegated').hide();
  $('time_choose').hide();
  $('time_start').hide();
  $('time_end').hide();
  $('time_choose_start').hide();
  $('time_choose_end').hide();
  $('next_action_info').update('');

  $('contexts').show();
  $('times').hide();
  $('energies').hide();
  $('priorities').hide();
}

Event.observe('next_action_DO_ASAP','click',function(e){
  activateDoASAP();
});

function activateDoASAP(){
var duedate = "<?php echo $duedate ?>";
  $('next_action_info').update('To do in date: <input onFocus="blur()" id="calendar_do_asap" name="calendar_do_asap" type="text" value="'+duedate+'" />');
  $('popupCalendar').hide();
  $('popupCalendar2').show();
  $('popupCalendar3').hide();
  $('popupDateField4').hide();
  $('time_delegated').hide();
  $('time_choose').hide();
  $('time_start').hide();
  $('time_end').hide();
  $('time_choose_start').hide();
  $('time_choose_end').hide();

  $('contexts').show();
  $('times').show();
  $('energies').show();
  $('priorities').show();
}


Event.observe('next_action_DELEGATED','click',function(e){
  activateDelegated();
});

function activateDelegated(){
  $('next_action_info').update('');
  $('popupCalendar').show();
  $('popupCalendar2').hide();
  $('popupCalendar3').hide();
  $('popupDateField4').hide();
  $('time_delegated').hide();
  $('time_choose').show();
  //SHOW THE INPUT FOR THE PERSON & CALENDAR
  $('next_action_info').update('Delegate to: <?php echo $form['delegate_to']->render(array('id'=>'delegate_to','name'=>'delegate_to','value'=>$delegate)) ?> Follow up date <input onFocus="blur()" id="calendar_delegated" name="calendar_delegated" type="text" value="<?php echo $followupdate ?>" />');

  $('contexts').show();
  $('times').show();
  $('energies').show();
  $('priorities').show();
}

Event.observe('next_action_SCHEDULED','click',function(e){
  activateScheduled();
});

function activateScheduled(){
  $('next_action_info').update('');
  //SHOW THE  CALENDAR
  $('popupCalendar3').show();
  $('time_choose').hide();
  $('popupCalendar2').hide();
  $('popupCalendar').hide();
  $('popupDateField4').show();
  $('next_action_info').update('To do in date: <input onFocus="blur()" id="calendar_scheluded_start" name="calendar_scheluded_start" type="text" value="<?php echo $todoindatestart; ?>" /><br/><input onFocus="blur()" id="calendar_scheluded_end" name="calendar_scheluded_end" type="text" value="<?php echo $todoindateend; ?>" />');
  
 // $('time_start').show();
 // $('time_end').show();
  $('time_choose_start').show();
  $('time_choose_end').show();
  
  $('contexts').show();
  $('times').hide();
  $('energies').hide();
  $('priorities').hide();
}

Event.observe('time_choose','click',function(e){
    $('time_delegated').show();
    if($('time_choose').hasClassName('elected')==true){
        $('time_choose').removeClassName('elected');
        $('time_delegated').hide();
    }else{
        $('time_choose').addClassName('elected');
        $('time_delegated').show();
    }
});

Event.observe('time_choose_start','click',function(e){
    $('time_start').show();
    if($('time_choose_start').hasClassName('elected')==true){
        $('time_choose_start').removeClassName('elected');
        $('time_start').hide();
    }else{
        $('time_choose_start').addClassName('elected');
        $('time_start').show();
    }
});

Event.observe('time_choose_end','click',function(e){
    $('time_end').show();
    if($('time_choose_end').hasClassName('elected')==true){
        $('time_choose_end').removeClassName('elected');
        $('time_end').hide();
    }else{
        $('time_choose_end').addClassName('elected');
        $('time_end').show();
    }
});

Event.observe('time_delegated','change',function(e){

        document.getElementById('time_choose').value=document.getElementById('time_delegated').value;
    $('time_delegated').hide();
});

Event.observe('time_start','change',function(e){

        document.getElementById('time_choose_start').value=document.getElementById('time_start').value;
    $('time_start').hide();
});

Event.observe('time_end','change',function(e){

        document.getElementById('time_choose_end').value=document.getElementById('time_end').value;
    $('time_end').hide();
});



Event.observe('relations','click',function(e){
    if($('project_id').hasClassName('elected')==true){
        $('project_id').removeClassName('elected');
        $('project_id').hide();
       } else {
           $('project_id').show();
           $('project_id').addClassName('elected');
       }

});



        // Popup Calendar
        
        Calendar.setup(
          {
            dateField: 'calendar_delegated',
            triggerElement: 'popupDateField'
          }
        );
        
        
        
        //catch a new calendar field
        Calendar.setup(
          {
            dateField: 'calendar_do_asap',
            triggerElement: 'popupDateField2'
          }
        );
        
        Calendar.setup(
          {
            dateField: 'calendar_scheluded_start',
            triggerElement: 'popupDateField3'
          }
        );
        
         Calendar.setup(
          {
            dateField: 'calendar_scheluded_end',
            triggerElement: 'popupDateField4'
          }
        );

//deleting attachments

<?php
//stuff case
if(is_object($stuff)){
foreach($stuff->getStuffAttachments() as $stuffAttachment){
  ?>
 Event.observe('delete_attachment_<?php echo $stuffAttachment->getId() ?>','click', function (e) {
  
  <?php
  
    echo remote_function(array(
        'update'=>'action_attachments',
        'url'=>'clarify_process/delete_attachment?id='.$stuffAttachment->getId(),
        'script'=>true,
        'complete'=>"$('action_attachments_".$stuffAttachment->getId()."').hide()"
        
      
      
    
    ));
  
   ?>
 
 }); 
  <?php
}}
?>

//deleting attachments

<?php
//next action case
if(isset($nextAction)){
  foreach($nextAction->getNextActionAttachments() as $nextAttachment){
  ?>
   Event.observe('delete_attachment_<?php echo $nextAttachment->getId() ?>','click', function (e) {
  
  <?php
  
    echo remote_function(array(
        'update'=>'action_attachments',
        'url'=>'clarify_process/delete_attachment?id='.$nextAttachment->getId(),
        'script'=>true,
        'complete'=>"$('action_attachments_".$nextAttachment->getId()."').hide()"
        
      
      
    
    ));
  
   ?>
 
   }); 
  <?php
  }
}
?>




   
  <!-- FORZAR LA CARGA DE LOS LINK POR QUE USA WINDOWS.load -->
  initModalbox();
  
</script>
