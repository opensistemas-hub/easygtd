<ul>
<?php foreach($typeNextActions as $key => $next){ ?>
<?php
$checked="";

if(!is_null($type)) {

if($type == $next->getDiscriminator()) {

 $checked = "checked"; 

 } else {

  $checked = "";

 } 
} else {

  if($key == 2) {
    $checked='checked="checked"';
  }

}
 
?>
  <li>
    <input <?php echo $checked; ?> style="vertical-align: middle; margin: 0px;" type="radio" name="next_action" id="next_action_<?php echo $next->getDiscriminator(); ?>" value="<?php echo $next->getDiscriminator(); ?>" /> <?php echo __($next->getMessage()) ?>
    <?php if ($next->getDiscriminator() == "DO_ASAP") { ?>
      <ul id="forms-do-asap">
        <li><span><?php echo __('When you'); ?></span> <?php
  
          if (isset($timeAvailable)) {
              include_partial('TIMES',array('times'=>$times,'timeAvailable'=>$timeAvailable));
          }  else {
              include_partial('TIMES',array('times'=>$times));
          } ?> 
          <div class="clear"></div>
        </li>
        <li>
            <span><?php echo __('When this'); ?></span> <?php if (isset($energy)) {  
                        include_partial('ENERGIES',array('energies'=>$energies,'energy'=>$energy));  
                      } else {  
                        include_partial('ENERGIES',array('energies'=>$energies)); 
                      } ?>
           <div class="clear"></div>
        </li>
        <li>
            <span><?php echo __('Although'); ?></span> <?php if (isset($priority)) {  
                        include_partial('PRIORITIES',array('priorities'=>$priorities,'priority'=>$priority));
                      } else {  
                        include_partial('PRIORITIES',array('priorities'=>$priorities)); 
                      } ?>
           <div class="clear"></div>
        </li>
        <li>
            <span><?php echo __('do_before'); ?></span>    
            <input id="calendar_do_asap" class="fecha datepicker" name="calendar_do_asap" type="hidden" value="<?php echo $duedate; ?>" />         

           <div class="clear"></div>
        </li>
    </ul> 
    <?php } ?>

    <?php if ($next->getDiscriminator() == "DELEGATED") { ?>
    <ul id="forms-delegate_to">
      <li><span><?php echo __('delegate_to'); ?></span>
                <?php echo $form['delegate_to']->render(array('id'=>'delegate_to','name'=>'delegate_to','value'=>$delegateto)) ;?>
          <div class="clear"></div>
      </li>
      <li><span><?php echo __('delegate_follow_up_date'); ?></span>
                <input onFocus="blur()" id="calendar_delegated" class="fecha datetimepicker" name="calendar_delegated" type="hidden" value="<?php echo $followupdate; ?>" />
          <div class="clear"></div>
      </li>
    </ul> 
    <?php } ?>

    <?php if ($next->getDiscriminator() == "SCHEDULED") { ?>
    <ul id="forms-scheluded">
      <li><span><?php echo __('start_date'); ?></span>
                <input onFocus="blur()" id="calendar_scheluded_start" class="fecha datetimepicker" name="calendar_scheluded_start" type="hidden" value="<?php echo $todoindatestart; ?>" />         
          <div class="clear"></div>
      </li>
      <li><span><?php echo __('end_date'); ?></span>
                <input onFocus="blur()" id="calendar_scheluded_end" class="fecha datetimepicker" name="calendar_scheluded_end" type="hidden" value="<?php echo $todoindateend; ?>" />
          <div class="clear"></div>
      </li>      
    </ul> 
    <?php } ?>

  </li>
<?php } ?>
</ul>

     
