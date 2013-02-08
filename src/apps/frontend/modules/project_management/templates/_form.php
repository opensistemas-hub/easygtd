<div class="form_project">

  <div class="content-general-with-mark">
    <h1><?php echo ($form->getObject()->isNew()) ? __('add_new_project') : __('edit_project'); ?></h1>
  </div>

  <div class="normal">

  <form id="project_form" name="project_form" enctype="multipart/form-data"  action="<?php echo url_for('project_management/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
   <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>

      <div class="etiqueta"><?php echo __('name')?>:</div><div class="valor"><?php echo $form['name']->render(array('id' => 'project_name','class'=>'campo_de_texto required','title'=>__('the_name_is_required'))) ?></div>
      <div class="clear"></div>

      <div class="etiqueta"><?php echo __('description')?>:</div><div class="valor"><?php echo $form['description']->render(array('id' => 'project_description','class'=>'campo_de_texto')) ?></div>
      <div class="clear"></div>

      <div class="etiqueta"><?php echo __('purpose')?>:</div><div class="valor"><?php echo $form['purpose']->render(array('class'=>'campo_de_texto')) ?></div>
      <div class="clear"></div>

      <div class="etiqueta"><?php echo __('vision')?>:</div><div class="valor"><?php echo $form['vision']->render(array('class'=>'campo_de_texto')) ?></div>
      <div class="clear"></div>

      <div class="etiqueta"><?php echo __('brainstorming')?>:</div><div class="valor"><?php echo $form['brainstorming']->render(array('class'=>'campo_de_texto')) ?></div>
      <div class="clear"></div>


      <?php echo $form->renderHiddenFields(true) ?>
      <div class="etiqueta">&nbsp;</div><div class="boton"><input id="save_project"type="submit" value="<?php echo __('save')?>" /></div>
      <div class="clear"></div>

   </form>
  </div>
</div>


<script type="text/javascript">

jq(function(){

  //Valores por defecto en caso de clarificar:
  if (jq('#project_id').length != 0) {
    jq("#project_name").val(jq("#name").val());
    jq("#project_description").val(jq("#description_text").val());
  }

  jq("#project_form").validate({
      invalidHandler : function() { jq.fancybox.resize(); }
  });

  jq('#project_form').ajaxForm({
     // dataType identifies the expected content type of the server response 
        dataType:  "xml",  
        // success identifies the function to invoke when the server response 
        // has been received 
        success:   function(responseXML) {
           var status = jq('status', responseXML).text(); 

           if (status == 'success') {
             if (jq('#list-project').length != 0) {
               jq('#list-project').load('<?php echo url_for("project_management/index_ajax") ?>', function(response, status, xhr) {
                 if (status == "success") {
                   <?php include_partial('global/modal'); ?>
                   corner_blocks();    
                 }
               });
             }
             //Si estoy en clarificar o editar - para actualizar el desplegable de proyectos
             if (jq('#project_id').length != 0) {
               jq('#project_list').load('<?php echo url_for("project_management/show_projects_in_combobox") ?>', function(response, status, xhr) {
                 if (status == "success") {
                   
                 } 
               });
             }
             //mensajes:              
             <?php if ($form->getObject()->isNew()) { ?> 
               renderMessages('<?php echo __("project_added_successful"); ?> ','success');
             <?php } else { ?> 
               renderMessages('<?php echo __("project_edited_successful"); ?> ','success');
             <?php } ?>
             jq.fancybox.close();
           }          

           if (status == 'error') {
             var message = jq('message', responseXML).text(); 
             renderMessages(message,'error');
           }

       },    
  });

});

</script>
