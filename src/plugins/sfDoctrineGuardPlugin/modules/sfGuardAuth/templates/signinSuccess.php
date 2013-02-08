<?php
$places = array(
                'menu'=>array(
                                array('name'=>__('login'),
                                       'url' => null
                                      )
                              )             
              );

include_partial('global/navigation_bar',array('places'=>$places,'header'=>__('authentication'),'helper' => false));  ?>  

<div id="principal">  

  	        <div class="content-with-shade">
            	<div class="content-general-with-mark">
            	  <h1><?php echo __('welcome_to');?></h1>
                </div>
                </div>

  <div class="normal"> 
  <h2>Está a punto de acceder a EasyGTD. Antes de acceder, tenga en cuenta lo
siguiente: 
    <ul style="margin-left:50px; margin-top:6px;">
      <li>- Si acaba de registrarse, el sistema requiere 10 minutos antes de activar el
acceso a la aplicación.</li>
      <li>- Los datos requeridos de autenticación son el email y la contraseña.</li>
    </ul>
  </h2>

  <?php echo form_tag('@sf_guard_signin',array('id'=>'login_form'))?>

    <div class="etiqueta"><?php echo __('email'); ?>:</div><div class="valor"><?php echo $form['username']->render(array('class'=>'campo_de_texto {required:true,messages:{required:\''.__('email_required').'\'}}' )) ?></div>
    <div class="clear"></div>  

    <div class="etiqueta"><?php echo __('password'); ?>:</div><div class="valor"><?php echo $form['password']->render(array('class'=>'campo_de_texto {required:true,messages:{required:\''.__('password_required').'\'}}','title'=>__('Enter your password'))) ?></div>
    <div class="clear"></div>  

    <?php echo $form['_csrf_token']->render() ?>

    <div class="etiqueta">&nbsp;</div><div class="boton"><input class="type-button" type="submit" value="<?php echo __('login') ?>" /></div>
    <div class="clear"></div>  

  </form>

  </div>

  <br/></br>

</div>

<script type="text/javascript">

//focus on username
jq('#signin_username').focus();

//JQUERY FUNCTION
jq(function(){
  jq("#login_form").validate({});
});

//Errores:  
<?php if ($form['username']->hasError()) { ?>
        renderMessages('<?php echo __($form['username']->getError()); ?>', 'error');
<?php } ?>

</script>
