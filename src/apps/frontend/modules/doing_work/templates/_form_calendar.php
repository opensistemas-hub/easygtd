<br/>
<br/>
<br/>

<div class="show_details_from_calendar">
<h1><?php echo __('add_action'); ?> <?php echo __('for'); ?> <?php echo $date?>
<br/><br/>
<?php echo form_tag('doing_work/save_calendar')?>

<input type="hidden" name="action_id" id="action_id" value="" />
<input type="hidden" id="form_date" name="form_date" value="<?php echo $date ?>" /> </td>




<table style="text-align: left; width: 498px; height: 184px;" border="0"
cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td style="vertical-align: top;"><?php echo __('name')?>:<br>
</td>
</tr>
<tr>
<td style="vertical-align: top;"><input name="action_name" id="action_name" type="text" value="" /><br>
</td>
</tr>
<tr>
<td style="vertical-align: top;"><?php echo __('description');?>:<br>
</td>
</tr>
<tr>
<td style="vertical-align: top;"><textarea id="action_description" name="action_description" rows="5" cols="40">
</textarea><br>
</td>
</tr>
<tr>
<td style="vertical-align: top;">
<table style="text-align: left; width: 480px; height: 33px;"
border="0" cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td style="vertical-align: top;"><?php echo __('context'); ?><br>
</td>
<td style="vertical-align: top;"><?php echo __('Time'); ?><br>
</td>
<td style="vertical-align: top;"><?php echo __('when_i_have')?><br>
</td>
<td style="vertical-align: top;"><?php echo __('when_i_have')?><br>
</td>
</tr>
<tr>
<td style="vertical-align: top;">
<select id="context[]" name="context[]" size=5 multiple>
<?php
#show contexts
$selected_context=null;
foreach ($contexts as $key => $context) {?>
<?php $selected_context = ($key == 0)?'selected':''; ?>
<option <?php echo $selected_context ?> value="<?php echo $context->getId();?>"><?php echo $context->getValue();?></option>
<?php 
}
#end show contexts
 ?>
 </select><br>
</td>
<td style="vertical-align: top;"><select id="time" name="time" >
<?php
#show times
foreach ($times as $time) {?>
  <option value="<?php echo $time->getId();?>"><?php echo $time->getValue();?> <?php echo $time->getUnit();?></option>
  <?php 
}
#end show times
 ?>
 </select><br>
</td>
<td style="vertical-align: top;"> <select id="energy" name="energy" >
<?php
#show contexts
foreach ($energies as $energy) {?>
<option value="<?php echo $energy->getId();?>"><?php  echo $energy->getValue();?></option>
<?php
}
#end show contexts
?>
</select><br>
</td>
<td style="vertical-align: top;"> <select id="priority" name="priority" >
<?php
#show priority
foreach ($priorities as $priority) {?>
<option value="<?php echo $priority->getId(); ?>"><?php echo $priority->getValue();?></option>
<?php
}
#end show contexts
 ?>
 </select><br>
</td>
</tr>
<tr>
  <td><br/><?php echo __('Repeat')?><br/></td>
</tr>
<tr>
  <td>
  
   <?php include_partial('repeat_event_form'); ?>
  
  </td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="vertical-align: top;"><input title="<?php echo __('You agree to accept the changes') ?>" class="type-button float-right" type="submit" value="<?php echo __('save') ?>" /><br>
</td>
</tr>
</tbody>
</table>


