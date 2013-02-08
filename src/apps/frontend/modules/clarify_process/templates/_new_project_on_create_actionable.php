<?php
#type:partial
#description:render form for add project on process action
?>
<?php echo __('This action also requires a new project'); ?>
<input type="checkbox" name="new_project_check" id="new_project_check" /><br/>

<div id="new-panel-project" class="close-panel">
<br/>
  <?php echo __('Enter the name of the new project') ?><br/>
  <input style="position:relative;left:15px;" type="text" value="" id="new_project" name="new_project" /><br/>
  <br/>
  <span id="error-text" style="color:red"><?php echo __('This name can not be used in a project')?></span>
  
</div>
<br/>
<script type="text/javascript">

  //estado inicial
  jq('#new-panel-project').hide();
  jq('#error-text').hide();
  
  jq('#new_project').bind('keyup',function(){
  
    var valor = jq(this).val();
    
    if (valor == '<?php echo sfConfig::get("app_DEFAULT_PROJECT")?>') {
    
      jq(this).addClass('error');
      jq('#error-text').show().html('<?php echo __("This name can not be used in a project")?>');

    
    }  
    
    else if (valor.length == 0) {
    
      jq('#error-text').show().html('<?php echo __("Required.") ?>');
      jq(this).addClass('error');
    
    } else {
    
      jq('#error-text').hide();
      jq(this).removeClass('error');
    
    
    }
  });
  
  //con evento click muestro u oculto el panel para el nuevo y asigno el valor del nuevo proyecto o lo elimino tambien
  
  jq('#new_project_check').bind('click',function(){
    
    //si la clase del panel es close, entonces muestra el panel y cambia la clase o viceversa
    
    if ( jq('#new-panel-project').hasClass('close-panel') ) {
      
      jq('#new-panel-project').show().removeClass('close-panel').addClass('open-panel');
      jq('#new_project').val( jq('#name').val() );
      var altura =  jq('#fancybox-wrap').height();
 	    jq('#fancybox-wrap').height(altura+100);
    
    } else {

      jq('#new-panel-project').hide().removeClass('open-panel').addClass('close-panel');
      jq('#new_project').val('');
      var altura =  jq('#fancybox-wrap').height();
 	jq('#fancybox-wrap').height(altura-100);
    }
    

  });


</script>
<br/>
