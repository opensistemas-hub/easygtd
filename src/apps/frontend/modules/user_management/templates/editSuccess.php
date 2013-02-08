<div class="form_settings">
  	  
  <div class="normal">   
    
    <?php echo form_tag('user_management/edit_user',array('id'=>'edit_user_form')); ?>

  <div class="content-general-with-mark">
    <h1><?php echo __('Configuration_email'); ?></h1>
  </div>

    <div class="etiqueta"><?php echo __('inbox_email')?>: </div><div class="valor"><input type="text" value="<?php echo $usernameEmailToInbox; ?>" size="15" id="inbox_email" name="inbox_email" class=""/>@inbox.easygtd.com</div>
    <div class="clear"></div>  

  <div class="content-general-with-mark">
    <h1><?php echo __('Change_password'); ?></h1>
  </div>

    <div class="etiqueta"><?php echo __('password')?>: </div><div class="valor"><input type="password" value="" id="password" name="password" size="15" class="{required:true,minlength:6,messages:{required:'<?php echo __('Required.')?>',minlength:'<?php echo __('Minimum length 6 characters') ?>'}}"/></div>
    <div class="clear"></div>  

    <div class="etiqueta"><?php echo __('repeat_password')?>: </div><div class="valor"><input type="password" value="" name="repeat-password" size="15" class="{required:true,minlength:6,equalTo:'#password',messages:{required:'<?php echo __('Required.')?>',minlength:'<?php echo __('Minimum length 6 characters')?>',equalTo:'<?php echo __('Passwords not match') ?>'}}"/></div>
    <div class="clear"></div>  

  <div class="content-general-with-mark">
    <h1><?php echo __('format'); ?></h1>
  </div>

    <div class="etiqueta"><?php echo __('date_format')?>: </div>
    <div class="valor">      
      <select name="format_date">
        <?php foreach (sfConfig::get('app_FORMAT_DATE') as $index => $data) { ?>
          <?php $selected = ($sf_user->getGuardUser()->getFormatDate() == $index) ? 'selected' : '' ; ?>
          <option value="<?php echo $index; ?>" <?php echo $selected; ?>><?php echo $data; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="clear"></div>

   <div class="etiqueta"><?php echo __('export_calendar')?>: </div>
    <div class="valor">      
      <?php echo url_for('@my_calendar?hash_calendar='.md5($sf_user->getGuardUser()->getUsername().$sf_user->getGuardUser()->getCreatedAt().$sf_user->getGuardUser()->getId()), true); ?>
    </div>
    <div class="clear"></div>    

    <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
    <div class="clear"></div>  
    
    </form>
  </div>
</div>


<script type="text/javascript">

jq(function(){

  jq.validator.addMethod("regex", function(value, element, param) { return value.match(new RegExp("^" + param + "$")); });
   var ALPHA_REGEX = "^[A-Za-z0-9._-]*[A-Za-z0-9._][A-Za-z0-9._-]*$";

  jq("#edit_user_form").validate({
    rules: {
      inbox_email: {
        regex: ALPHA_REGEX,
        required: true,        
      } 
    },
    messages: {
            inbox_email: {
              regex: "<?php echo __('Username must contain only letters,dot, underscore, minus and numbers'); ?>",
              required: "<?php echo __('Required.'); ?>",              
              }
    }
  });

  jq('#edit_user_form').ajaxForm({ 
        // dataType identifies the expected content type of the server response 
        dataType:  "xml",  
        // success identifies the function to invoke when the server response 
        // has been received 
        success:   function(responseXML) {
           var status = jq('status', responseXML).text(); 
           if (status == 'success') {             
             //mensajes:
             renderMessages('<?php echo __("The user was successfully edited"); ?> ','success');
             jq.fancybox.close();
           }
           if (status == 'error') {
             var message = jq('message', responseXML).text(); 
             renderMessages(message,'error');
           } 
        }
    });

});

</script>
