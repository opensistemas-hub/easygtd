<div class="errors">
<?php 
echo $form['email']->renderError();
echo $form->renderGlobalErrors();
?> 

</div>
<?php echo form_tag('user_management/process_alert',array('id'=>'alert_form'))?>

<br/><br/>

<?php
$field = array();
  foreach ($datas as $row ) {
    $field[] =  $row->getValue();
  }
$email = (isset($field[0]))?$field[0]:'';
?>

<label for="email"><?php echo __('email_account')?></label>
<?php echo $form['email']->render(array('id'=>'email','value'=>$email,'class'=>'required email','title'=> __('this_email_is_not_valid')))?>
&nbsp;
<input title="<?php echo __('Use your account email EasyGTD to fill the need and send email alerts to this email')?>" type="button" id="get_email" value="<?php echo __('Use my account'); ?>"/><br>

<br/><br/>



<table width="700" border="0">
  <tr>
    <td width="139"><font ><?php echo __('things_to_check_to_tell_me')?></font></td>
    <td width="317" rowspan="5" valign="top">
    
    
    <?php echo __('remember').' '?>
<select id="time-remember" name="time-remember">
  <option <?php echo ($field[5] == 0)?'selected':''; ?> value="0"><?php echo __('the_same_day'); ?></option>
  <option <?php echo ($field[5] == 1)?'selected':''; ?> value="1"><?php echo __('1_day'); ?></option>
  <option <?php echo ($field[5] == 2)?'selected':''; ?> value="2"><?php echo __('2_days'); ?></option>
  <option <?php echo ($field[5] == 7)?'selected':''; ?> value="7"><?php echo __('1_week'); ?></option>
  <option <?php echo ($field[5] == 14)?'selected':''; ?> value="14"><?php echo __('2_weeks'); ?></option>
  <option <?php echo ($field[5] == 24)?'selected':''; ?> value="24"><?php echo __('4_weeks'); ?></option>
</select>

 <font id="before_text"><?php echo __('before'); ?>.</font>
    
    </td>
  </tr>
  <tr>
    <td><input type="checkbox" name="scheluded_type" value="true" <?php echo ($field[2] == 1)?'checked':''; ?>><?php echo __('scheduled_items') ?></td>
  </tr>
  <tr>
    <td><input type="checkbox" name="delegated_type" value="true" <?php echo ($field[3] == 1)?'checked':''; ?>><?php echo __('delegated_items') ?></td>
  </tr>
  <tr>
    <td><input type="checkbox" name="doasap_type" value="true" <?php echo ($field[4] == 1)?'checked':''; ?>><?php echo __('do_asap_items') ?></td>
  </tr>
  <tr>
    <td> <input type="checkbox" name="someday_type" value="true" <?php echo ($field[1] == 1)?'checked':''; ?>><?php echo __('someday_items') ?></td>
  </tr>
</table>
<input class="type-button" type="submit" value="<?php echo __('save'); ?>" />






</form>
<script type="text/javascript">
jq(document).ready(function() {
  jq('#get_email').button();
  jq.metadata.setType("attr", "validate");
	
	jq("#alert_form").validate();
	
	
});

if (jq('#time-remember').val() == 0) {
  jq('#before_text').hide();
}

jq('#time-remember').change(function(){
  
  if (jq('#time-remember').val() == 0) {
    jq('#before_text').hide();
  } else {
    jq('#before_text').show();
  }  
  
});
 

</script>

