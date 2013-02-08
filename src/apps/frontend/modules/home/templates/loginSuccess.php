<?php include_partial('global/mensajes'); ?>

<?php
$places = array(
                'menu'=>array(
                                array('name'=>__('login'),
                                       'url' => null
                                      )
                              )             
              );



 include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('authentication'),'helper' => false))

?>  
  	  
<div class="normal">

<?php echo form_tag('home/login',array('id'=>'login_form')) ?>

<table style="width:380px;margin:auto;">
<tr>
  <td><?php echo __('email'); ?>:</td>
  <td><?php echo $form['email']->render(array('id'=>'email','class'=>'{required:true,messages:{required:\''.__('Required.').'\'}}'))?></td>
</tr>
<tr>
  <td><?php echo __('password'); ?>:</td>
  <td><?php echo $form['password']->render(array('id'=>'password','class'=>'{required:true,messages:{required:\''.__('Required.').'\'}}'))?></td>
</tr>
<tr>
  <td colspan="2" align="center"><input id="rememberme" type="checkbox"><?php echo __('Remember me')?></td>
  <td></td>
</tr>
<tr>
  
  <td colspan="2"><input type="submit" value="<?php echo __('login'); ?>"/></td>
  <td></td>
</tr>

</table>
</form>

  <?php echo __('if_you_do_not_have_a_account_press').' '.link_to(__('here'),'home/show_register',array('class'=>'','accesskey'=>'h')); ?>

 

</div>

<script type="text/javascript">
//focus on username
jq('#email').focus();

//JQUERY FUNCTION
jq(function(){



	
jq("#login_form").validate({});



jq ('#rememberme').click(function(){
  
  if (jq('#rememberme').attr('checked')) {
    var email = jq('#email').val();
    var password = jq('#password').val();
    
    jq.cookie('email',email,{expires:15});
    jq.cookie('password',password,{expires:15});
    jq.cookie('remember',true,{expires:15}); 
  
  } else {
  
    jq.cookie('email','',{expires:1});
    jq.cookie('password','',{expires:1});
    jq.cookie('remember','',{expires:1}); 
  
  }

});

if (jq.cookie('remember')) {
  
  jq('#email').val(jq.cookie('email'));
  jq('#password').val(jq.cookie('password'));
  jq('#rememberme').attr('checked',true);

}

})

</script>
