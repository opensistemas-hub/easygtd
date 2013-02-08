<div class="form_folder">

<div class="content-general-with-mark">
  <h1><?php echo ($form->getObject()->isNew()) ? __('add_new_folder') : __('edit_folder'); ?></h1>
</div>

<div class="normal">
  <form id="folder_form" name="folder_form" enctype="multipart/form-data" action="<?php echo url_for('folder_management/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php if (!$form->getObject()->isNew()): ?>
      <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>

    <div class="etiqueta"><?php echo __('name')?>:</div><div class="valor"><?php echo $form['name']->render(array('class'=>'campo_de_texto required','title'=>__('the_name_is_required'))) ?></div>
    <div class="clear"></div>  

    <?php echo $form->renderHiddenFields(true) ?>
    <div class="etiqueta">&nbsp;</div><div class="boton"><input type="submit" value="<?php echo __('save')?>" /></div>
    <div class="clear"></div>  

   </form>
</div>

</div>

<script type="text/javascript">

jq(function(){
	
  jq("#folder_form").validate({});

  jq('#folder_form').ajaxForm({ 
        // dataType identifies the expected content type of the server response 
        dataType:  "xml",  
        // success identifies the function to invoke when the server response 
        // has been received 
        success:   function(responseXML) {
           var status = jq('status', responseXML).text(); 

           if (status == 'success') {
             if (jq('#list-folder').length != 0) {
               jq('#list-folder').load('<?php echo url_for("folder_management/indexAjax") ?>', function(response, status, xhr) {
                 if (status == "success") {
                   <?php include_partial('global/modal'); ?>      
                   corner_blocks();          
                 } 
               });
             }
             //mensajes:
             <?php if ($form->getObject()->isNew()) { ?> 
                renderMessages('<?php echo __("folder_added_successful"); ?> ','success');
             <?php } else { ?> 
               renderMessages('<?php echo __("folder_edited_successful"); ?> ','success');
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
