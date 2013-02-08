<?php
$places = array(
                'menu'=>array(
                                array(
                                       'name'=>__('register'),
                                       'url' => null
                                     )
                              )             
          );

 include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('register'),'helper' => false));

?>  


 
<?php echo form_tag('register/index?hash='.$hash_return,array('id'=>'user_register')) ?>

  
  
  <div id="error"></div>
  
  <table style="width:500px;margin:auto;">
   
   <tr>
   <td><h1><?php echo __('email')?>: </h1></td>
   <td><?php echo $form['username']->render(array('class'=>'defaultText {required:true,email:true,messages:{required:\''.__('The email is required').'\',email:\''.__('Not correspond to a valid email').'\'}}','title'=>__('e.g. someone@example.com')))?></td>
   </tr>
   <tr>
   <td><h1><?php echo __('password');?>: </h1></td>
   <td><?php echo $form['password']->render(array('id'=>'password','class'=>'{required:true,messages:{required:\''.__('Required.').'\'}}'))?></td>
   </tr>
   <tr>
   <td><h1><?php echo __('repeat_password');?>:</h1></td>
   <?php //echo $form['_csrf_token']->render() ?>
   <td><?php echo $form['password_confirmation']->render(array('class'=>'{required:true,equalTo:\'#password\',messages:{required:\''.__('Required.').'\',equalTo:\''.__('Passwords not match').'\'}}'))?></td>
   </tr>
   
   
    <tr>
    <br/>
      <td colspan="2" align="center">
        <input class="type-button" type="submit" name="submit" value="<?php echo __('register')?>"/>
      </td>
      <td></td>
    </tr>
  </table>
</form>
  

</div>

<script type="text/javascript">

jq('#error').hide();
<?php if ($form['username']->renderError()):?>
  
  renderMessages('<?php echo __("The already exist")?>','error','error');
<?php endIf;?>

//validation 
jq(function(){
	
 jq("#user_register").validate({});

});

</script>

